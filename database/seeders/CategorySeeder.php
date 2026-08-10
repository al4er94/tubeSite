<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'slug'         => 'mountains',
                'translations' => [
                    'en' => ['title' => 'Mountains',       'description' => 'Photos of mountain landscapes, peaks and alpine scenery.'],
                    'ru' => ['title' => 'Горы',            'description' => 'Фотографии горных пейзажей, вершин и альпийских видов.'],
                    'de' => ['title' => 'Berge',           'description' => 'Fotos von Berglandschaften, Gipfeln und alpinen Szenerien.'],
                    'fr' => ['title' => 'Montagnes',       'description' => 'Photos de paysages de montagne, de sommets et de scènes alpines.'],
                ],
            ],
            [
                'slug'         => 'forests',
                'translations' => [
                    'en' => ['title' => 'Forests',         'description' => 'Dense woods, forest paths and misty woodland scenes.'],
                    'ru' => ['title' => 'Леса',            'description' => 'Густые леса, лесные тропы и туманные лесные пейзажи.'],
                    'de' => ['title' => 'Wälder',          'description' => 'Dichte Wälder, Waldwege und neblige Waldszenen.'],
                    'fr' => ['title' => 'Forêts',          'description' => 'Forêts denses, sentiers forestiers et scènes boisées brumeuses.'],
                ],
            ],
            [
                'slug'         => 'sea-and-ocean',
                'translations' => [
                    'en' => ['title' => 'Sea & Ocean',     'description' => 'Coastal views, seascapes and ocean photography.'],
                    'ru' => ['title' => 'Море и океан',    'description' => 'Прибрежные виды, морские пейзажи и фотографии океана.'],
                    'de' => ['title' => 'Meer & Ozean',    'description' => 'Küstenansichten, Meereslandschaften und Ozeanfotografie.'],
                    'fr' => ['title' => 'Mer & Océan',     'description' => 'Vues côtières, paysages marins et photographie océanique.'],
                ],
            ],
            [
                'slug'         => 'landscapes',
                'translations' => [
                    'en' => ['title' => 'Landscapes',      'description' => 'Open landscapes including hills, fields and aerial views.'],
                    'ru' => ['title' => 'Пейзажи',         'description' => 'Открытые пейзажи: холмы, поля и виды с воздуха.'],
                    'de' => ['title' => 'Landschaften',    'description' => 'Offene Landschaften mit Hügeln, Feldern und Luftaufnahmen.'],
                    'fr' => ['title' => 'Paysages',        'description' => 'Paysages ouverts incluant collines, champs et vues aériennes.'],
                ],
            ],
        ];

        foreach ($categories as $data) {
            $category = Category::create(['slug' => $data['slug']]);

            foreach ($data['translations'] as $locale => $translation) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale'      => $locale,
                    'title'       => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }
        }
    }
}
