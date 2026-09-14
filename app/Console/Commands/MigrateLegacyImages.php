<?php

namespace App\Console\Commands;

use App\Console\Commands\Concerns\GeneratesUniqueSlugs;
use App\Models\Category;
use App\Models\Image;
use App\Models\ImageTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateLegacyImages extends Command
{
    use GeneratesUniqueSlugs;

    /**
     * php artisan legacy:migrate-images           — перенести video_contents + video_categories
     * php artisan legacy:migrate-images --dry-run  — только показать план, ничего не сохранять
     */
    protected $signature = 'legacy:migrate-images {--dry-run : Ничего не сохранять, только показать план}';

    protected $description = 'Переносит video_contents (+ пивот video_categories) в images / image_translations / category_image';

    public function handle(): int
    {
        if (!Schema::hasTable('video_contents')) {
            $this->error('Таблица video_contents не найдена.');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');

        $this->migrateImages($dryRun);

        if (Schema::hasTable('video_categories')) {
            $this->migrateCategoryLinks($dryRun);
        } else {
            $this->comment('Таблица video_categories не найдена — связи с категориями пропущены.');
        }

        return self::SUCCESS;
    }

    private function migrateImages(bool $dryRun): void
    {
        $legacyRows = DB::table('video_contents')->orderBy('id')->get();

        $this->info("Найдено legacy-видео: {$legacyRows->count()}" . ($dryRun ? ' (dry-run, ничего не сохраняется)' : ''));

        $created = 0;
        $skipped = 0;
        $missingFiles = 0;

        foreach ($legacyRows as $legacy) {
            if (Image::where('legacy_id', $legacy->id)->exists()) {
                $skipped++;
                continue;
            }

            $path = $this->resolvePath($legacy->previewUrl);

            if ($path === null || !Storage::disk('public')->exists($path)) {
                $missingFiles++;
                $this->warn("[{$legacy->id}] файл не найден на диске: " . ($path ?? $legacy->previewUrl) . ' — запись всё равно будет создана');
            }

            $slug = $this->uniqueSlug(Image::class, Str::slug($legacy->name) ?: "video-{$legacy->id}");

            $translations = [
                'en' => ['title' => $legacy->name, 'description' => $legacy->description],
                'ru' => ['title' => $legacy->name_ru, 'description' => $legacy->description_ru],
                'de' => ['title' => $legacy->name_de, 'description' => $legacy->description_de],
            ];

            $this->line("[{$legacy->id}] vk_id={$legacy->vkId} -> slug \"{$slug}\", path \"{$path}\"");

            if ($dryRun) {
                $created++;
                continue;
            }

            DB::transaction(function () use ($legacy, $path, $slug, $translations) {
                $image = Image::create([
                    'legacy_id'  => $legacy->id,
                    'vk_id'      => $legacy->vkId,
                    'path'       => $path ?? $legacy->previewUrl,
                    'slug'       => $slug,
                    'link'       => $legacy->url,
                    'views'      => $legacy->views,
                    'likes'      => $legacy->likes,
                    'created_at' => $legacy->created_at,
                    'updated_at' => $legacy->updated_at,
                ]);

                foreach ($translations as $locale => $data) {
                    if (blank($data['title'])) {
                        continue;
                    }

                    ImageTranslation::create([
                        'image_id'    => $image->id,
                        'locale'      => $locale,
                        'title'       => $data['title'],
                        'description' => $data['description'],
                    ]);
                }
            });

            $created++;
        }

        $this->newLine();
        $this->info("Изображения — создано: {$created}, пропущено (уже были): {$skipped}, без файла на диске: {$missingFiles}.");
    }

    private function migrateCategoryLinks(bool $dryRun): void
    {
        $imageIdByLegacy = Image::whereNotNull('legacy_id')->pluck('id', 'legacy_id');
        $categoryIdByLegacy = Category::whereNotNull('legacy_id')->pluck('id', 'legacy_id');

        $links = DB::table('video_categories')->select('video_id', 'category_id')->get();

        $rows = [];
        $missingImage = 0;
        $missingCategory = 0;

        foreach ($links as $link) {
            $imageId = $imageIdByLegacy[$link->video_id] ?? null;
            $categoryId = $categoryIdByLegacy[$link->category_id] ?? null;

            if (!$imageId) {
                $missingImage++;
                continue;
            }

            if (!$categoryId) {
                $missingCategory++;
                continue;
            }

            $rows[] = ['category_id' => $categoryId, 'image_id' => $imageId];
        }

        $this->info('Связей image<->category к переносу: ' . count($rows) .
            ($missingImage ? ", без найденного изображения: {$missingImage}" : '') .
            ($missingCategory ? ", без найденной категории: {$missingCategory}" : '') .
            ($dryRun ? ' (dry-run, ничего не сохраняется)' : ''));

        if ($dryRun || empty($rows)) {
            return;
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('category_image')->insertOrIgnore($chunk);
        }

        $this->info('Связи category_image записаны.');
    }

    private function resolvePath(?string $previewUrl): ?string
    {
        if (blank($previewUrl)) {
            return null;
        }

        // "assets/videos/xxx.jpg" (старый путь относительно public/) -> "videos/xxx.jpg" (относительно storage/app/public)
        return Str::startsWith($previewUrl, 'assets/')
            ? Str::after($previewUrl, 'assets/')
            : $previewUrl;
    }
}
