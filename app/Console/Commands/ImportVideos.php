<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Image;
use App\Models\ImageTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportVideos extends Command
{
    protected $signature = 'import:videos {file=backup.sql}';
    protected $description = 'Import video_contents from a mysqldump SQL file as images';

    public function handle(): int
    {
        $file = base_path($this->argument('file'));

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return self::FAILURE;
        }

        $sql = file_get_contents($file);

        // Build old_category_id → new_category_id mapping via slug matching
        $categoryMap = $this->buildCategoryMap($sql);
        $this->line('Category map: ' . count($categoryMap) . ' entries');

        // Parse video_categories: old_video_id → [new_category_ids]
        $videoCategories = $this->parseVideoCategories($sql, $categoryMap);
        $this->line('Video-category relations: ' . array_sum(array_map('count', $videoCategories)) . ' links across ' . count($videoCategories) . ' videos');

        if (!preg_match('/INSERT INTO `video_contents` VALUES (.+);/s', $sql, $matches)) {
            $this->error('No video_contents INSERT found in SQL file.');
            return self::FAILURE;
        }

        $rows = $this->parseValues($matches[1]);
        $this->line('Video records found: ' . count($rows));
        $this->newLine();

        $imported = 0;
        $skipped  = 0;
        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        foreach ($rows as $row) {
            // Columns: 0:id, 1:vkId, 2:name(en), 3:name_ru, 4:name_de,
            //          5:description(en), 6:description_ru, 7:description_de,
            //          8:url, 9:previewUrl, 10:views, 11:likes
            $oldId      = (int) $row[0];
            $vkId       = (int) $row[1];
            $nameEn     = $row[2] ?? '';
            $nameRu     = ($row[3] ?? '') ?: $nameEn;
            $nameDe     = ($row[4] ?? '') ?: $nameEn;
            $descEn     = ($row[5] ?? '') ?: null;
            $descRu     = ($row[6] ?? '') ?: null;
            $descDe     = ($row[7] ?? '') ?: null;
            $link       = ($row[8] ?? '') ?: null;
            $previewUrl = $row[9] ?? '';
            $views      = (int) ($row[10] ?? 0);
            $likes      = (int) ($row[11] ?? 0);

            // 'assets/videos/xxx.jpg' → 'videos/xxx.jpg'
            $path = preg_replace('#^assets/#', '', $previewUrl);

            // Skip if file doesn't exist in storage
            if (!file_exists(storage_path('app/public/' . $path))) {
                $skipped++;
                $bar->advance();
                continue;
            }

            // Skip duplicates by vk_id
            if (Image::where('vk_id', $vkId)->exists()) {
                $skipped++;
                $bar->advance();
                continue;
            }

            // Slug from English title, fallback to vk_id
            $slug = Str::slug($nameEn) ?: 'video-' . $vkId;

            // Ensure slug uniqueness
            $baseSlug = $slug;
            $suffix   = 1;
            while (Image::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $suffix++;
            }

            DB::transaction(function () use (
                $vkId, $slug, $path, $link, $views, $likes,
                $nameEn, $nameRu, $nameDe, $descEn, $descRu, $descDe,
                $oldId, $videoCategories
            ) {
                $image = Image::create([
                    'vk_id' => $vkId,
                    'path'  => $path,
                    'slug'  => $slug,
                    'link'  => $link,
                    'views' => $views,
                    'likes' => $likes,
                ]);

                $translations = [
                    ['locale' => 'en', 'title' => $nameEn, 'description' => $descEn],
                    ['locale' => 'ru', 'title' => $nameRu, 'description' => $descRu],
                    ['locale' => 'de', 'title' => $nameDe, 'description' => $descDe],
                    ['locale' => 'fr', 'title' => $nameEn, 'description' => $descEn],
                ];

                foreach ($translations as $t) {
                    ImageTranslation::create([
                        'image_id'    => $image->id,
                        'locale'      => $t['locale'],
                        'title'       => $t['title'],
                        'description' => $t['description'],
                    ]);
                }

                if (!empty($videoCategories[$oldId])) {
                    $image->categories()->attach($videoCategories[$oldId]);
                }
            });

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Done. Imported: {$imported}, Skipped: {$skipped}.");
        return self::SUCCESS;
    }

    private function buildCategoryMap(string $sql): array
    {
        if (!preg_match('/INSERT INTO `categories` VALUES (.+?);/s', $sql, $m)) {
            return [];
        }

        $rows = $this->parseValues($m[1]);
        // Backup columns: 0:id, 1:created_at, 2:updated_at, 3:img_url, 4:name(en)
        $slugToNewId = Category::all()->pluck('id', 'slug')->toArray();

        $map = [];
        foreach ($rows as $row) {
            $oldId = (int) $row[0];
            $slug  = Str::slug($row[4] ?? '');
            if ($slug && isset($slugToNewId[$slug])) {
                $map[$oldId] = $slugToNewId[$slug];
            }
        }

        return $map;
    }

    private function parseVideoCategories(string $sql, array $categoryMap): array
    {
        if (!preg_match('/INSERT INTO `video_categories` VALUES (.+?);/s', $sql, $m)) {
            return [];
        }

        $rows = $this->parseValues($m[1]);
        // Columns: 0:id, 1:video_id, 2:category_id

        $result = [];
        foreach ($rows as $row) {
            $videoId  = (int) $row[1];
            $oldCatId = (int) $row[2];
            $newCatId = $categoryMap[$oldCatId] ?? null;

            if ($newCatId) {
                $result[$videoId][] = $newCatId;
            }
        }

        return $result;
    }

    private function parseValues(string $valuesStr): array
    {
        $rows = [];
        $i    = 0;
        $len  = strlen($valuesStr);

        while ($i < $len) {
            while ($i < $len && $valuesStr[$i] !== '(') {
                $i++;
            }
            if ($i >= $len) break;
            $i++;

            $row = [];

            while (true) {
                while ($i < $len && $valuesStr[$i] === ' ') {
                    $i++;
                }

                if ($i >= $len || $valuesStr[$i] === ')') {
                    $i++;
                    break;
                }

                if ($valuesStr[$i] === '\'') {
                    $i++;
                    $value = '';
                    while ($i < $len) {
                        if ($valuesStr[$i] === '\\' && $i + 1 < $len) {
                            $value .= $valuesStr[$i + 1];
                            $i += 2;
                        } elseif ($valuesStr[$i] === '\'' && isset($valuesStr[$i + 1]) && $valuesStr[$i + 1] === '\'') {
                            $value .= '\'';
                            $i += 2;
                        } elseif ($valuesStr[$i] === '\'') {
                            $i++;
                            break;
                        } else {
                            $value .= $valuesStr[$i];
                            $i++;
                        }
                    }
                    $row[] = $value;
                } else {
                    $end = $i;
                    while ($end < $len && $valuesStr[$end] !== ',' && $valuesStr[$end] !== ')') {
                        $end++;
                    }
                    $token = trim(substr($valuesStr, $i, $end - $i));
                    $row[] = strtoupper($token) === 'NULL' ? null : $token;
                    $i     = $end;
                }

                if ($i < $len && $valuesStr[$i] === ',') {
                    $i++;
                }
            }

            if (!empty($row)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
}
