<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportCategories extends Command
{
    protected $signature = 'import:categories {file=backup.sql}';
    protected $description = 'Import categories from a mysqldump SQL file into the project';

    public function handle(): int
    {
        $file = base_path($this->argument('file'));

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return self::FAILURE;
        }

        $sql = file_get_contents($file);

        if (!preg_match('/INSERT INTO `categories` VALUES (.+);/s', $sql, $matches)) {
            $this->error('No categories INSERT statement found in the SQL file.');
            return self::FAILURE;
        }

        $rows = $this->parseValues($matches[1]);

        $imported = 0;
        $skipped  = 0;

        foreach ($rows as $row) {
            // Backup columns order:
            // 0:id, 1:created_at, 2:updated_at, 3:img_url,
            // 4:name(en), 5:name_ru, 6:name_de,
            // 7:description(en), 8:description_ru, 9:description_de
            $nameEn  = $row[4] ?? '';
            $nameRu  = $row[5] ?? $nameEn;
            $nameDe  = $row[6] ?? $nameEn;
            $descEn  = ($row[7] ?? '') ?: null;
            $descRu  = ($row[8] ?? '') ?: null;
            $descDe  = ($row[9] ?? '') ?: null;

            $slug = Str::slug($nameEn);

            if (!$slug) {
                $this->warn("Skipped (empty name): row id={$row[0]}");
                $skipped++;
                continue;
            }

            if (Category::where('slug', $slug)->exists()) {
                $this->line("  Skipped (already exists): {$nameEn}");
                $skipped++;
                continue;
            }

            $category = Category::create(['slug' => $slug]);

            $translations = [
                ['locale' => 'en', 'title' => $nameEn, 'description' => $descEn],
                ['locale' => 'ru', 'title' => $nameRu, 'description' => $descRu],
                ['locale' => 'de', 'title' => $nameDe, 'description' => $descDe],
                ['locale' => 'fr', 'title' => $nameEn, 'description' => $descEn], // fallback to EN
            ];

            foreach ($translations as $t) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale'      => $t['locale'],
                    'title'       => $t['title'],
                    'description' => $t['description'],
                ]);
            }

            $this->line("  Imported: {$nameEn}");
            $imported++;
        }

        $this->newLine();
        $this->info("Done. Imported: {$imported}, Skipped: {$skipped}.");
        return self::SUCCESS;
    }

    /**
     * Parse the VALUES(...),(...) part of an INSERT statement.
     * Handles NULL, numeric values, and single-quoted strings with escape sequences.
     */
    private function parseValues(string $valuesStr): array
    {
        $rows = [];
        $i    = 0;
        $len  = strlen($valuesStr);

        while ($i < $len) {
            // Seek to the opening parenthesis of the next row
            while ($i < $len && $valuesStr[$i] !== '(') {
                $i++;
            }
            if ($i >= $len) break;
            $i++; // skip '('

            $row = [];

            while (true) {
                // Skip spaces
                while ($i < $len && $valuesStr[$i] === ' ') {
                    $i++;
                }

                if ($i >= $len || $valuesStr[$i] === ')') {
                    $i++;
                    break;
                }

                if ($valuesStr[$i] === '\'') {
                    // Single-quoted string
                    $i++;
                    $value = '';
                    while ($i < $len) {
                        if ($valuesStr[$i] === '\\' && $i + 1 < $len) {
                            // Backslash escape
                            $value .= $valuesStr[$i + 1];
                            $i += 2;
                        } elseif ($valuesStr[$i] === '\'' && isset($valuesStr[$i + 1]) && $valuesStr[$i + 1] === '\'') {
                            // Double-quote escape ''
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
                    // Unquoted token: NULL or a number
                    $end = $i;
                    while ($end < $len && $valuesStr[$end] !== ',' && $valuesStr[$end] !== ')') {
                        $end++;
                    }
                    $token = trim(substr($valuesStr, $i, $end - $i));
                    $row[] = strtoupper($token) === 'NULL' ? null : $token;
                    $i = $end;
                }

                // Skip comma separator
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
