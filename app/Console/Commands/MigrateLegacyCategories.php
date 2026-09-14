<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MigrateLegacyCategories extends Command
{
    /**
     * php artisan legacy:migrate-categories          — выполнить перенос
     * php artisan legacy:migrate-categories --dry-run — только показать, что будет сделано
     */
    protected $signature = 'legacy:migrate-categories {--dry-run : Ничего не сохранять, только показать план}';

    protected $description = 'Переносит categories_legacy (старая схема с колонками-языками) в новые categories + category_translations';

    public function handle(): int
    {
        if (!Schema::hasTable('categories_legacy')) {
            $this->error('Таблица categories_legacy не найдена. Перенос уже выполнен или таблицу переименовали иначе?');

            return self::FAILURE;
        }

        $dryRun = (bool) $this->option('dry-run');
        $legacyRows = DB::table('categories_legacy')->orderBy('id')->get();

        $this->info("Найдено legacy-категорий: {$legacyRows->count()}" . ($dryRun ? ' (dry-run, ничего не сохраняется)' : ''));

        $created = 0;
        $skipped = 0;

        foreach ($legacyRows as $legacy) {
            $existing = Category::where('legacy_id', $legacy->id)->first();

            if ($existing) {
                $this->line("[skip] legacy_id={$legacy->id} уже перенесена -> category #{$existing->id} ({$existing->slug})");
                $skipped++;
                continue;
            }

            $slug = $this->uniqueSlug(Str::slug($legacy->name) ?: "category-{$legacy->id}");

            $translations = [
                'en' => ['title' => $legacy->name, 'description' => $legacy->description],
                'ru' => ['title' => $legacy->name_ru, 'description' => $legacy->description_ru],
                'de' => ['title' => $legacy->name_de, 'description' => $legacy->description_de],
            ];

            $this->line("[{$legacy->id}] \"{$legacy->name}\" -> slug \"{$slug}\"");

            if ($dryRun) {
                $created++;
                continue;
            }

            DB::transaction(function () use ($legacy, $slug, $translations) {
                $category = Category::create([
                    'legacy_id'  => $legacy->id,
                    'slug'       => $slug,
                    'created_at' => $legacy->created_at,
                    'updated_at' => $legacy->updated_at,
                ]);

                foreach ($translations as $locale => $data) {
                    if (blank($data['title'])) {
                        continue;
                    }

                    CategoryTranslation::create([
                        'category_id' => $category->id,
                        'locale'      => $locale,
                        'title'       => $data['title'],
                        'description' => $data['description'],
                    ]);
                }
            });

            $created++;
        }

        $this->newLine();
        $this->info("Готово. Создано: {$created}, пропущено (уже были): {$skipped}.");
        $this->comment('Перевода на fr в legacy-таблице нет — для fr сработает фолбэк на дефолтную локаль (см. Category::translation()).');

        return self::SUCCESS;
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$base}-" . $i++;
        }

        return $slug;
    }
}
