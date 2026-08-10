<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class SimilarImageSeeder extends Seeder
{
    public function run(): void
    {
        // Define similar images by slug pairs (bidirectional)
        $pairs = [
            ['mountain-peaks-at-sunset', 'waterfall-in-the-mountains'],
            ['mountain-peaks-at-sunset', 'snowy-mountain-night'],
            ['mountain-peaks-at-sunset', 'aerial-view'],
            ['waterfall-in-the-mountains', 'snowy-mountain-night'],
            ['waterfall-in-the-mountains', 'autumn-forest-river'],
            ['forest-path-in-the-mist', 'autumn-forest-river'],
            ['forest-path-in-the-mist', 'green-hills-in-summer'],
            ['forest-path-in-the-mist', 'waterfall-in-the-mountains'],
            ['calm-sea-at-dawn', 'tropical-beach-cove'],
            ['calm-sea-at-dawn', 'aerial-view'],
            ['green-hills-in-summer', 'aerial-view'],
            ['green-hills-in-summer', 'autumn-forest-river'],
            ['tropical-beach-cove', 'calm-sea-at-dawn'],
            ['snowy-mountain-night', 'aerial-view'],
            ['autumn-forest-river', 'forest-path-in-the-mist'],
        ];

        $cache = [];

        $resolve = function (string $slug) use (&$cache): ?int {
            if (! isset($cache[$slug])) {
                $cache[$slug] = Image::where('slug', $slug)->value('id');
            }
            return $cache[$slug];
        };

        foreach ($pairs as [$slugA, $slugB]) {
            $idA = $resolve($slugA);
            $idB = $resolve($slugB);

            if (! $idA || ! $idB) {
                continue;
            }

            $imageA = Image::find($idA);
            $imageB = Image::find($idB);

            // Attach bidirectionally, ignoring duplicates
            if (! $imageA->similar()->where('similar_image_id', $idB)->exists()) {
                $imageA->similar()->attach($idB);
            }
            if (! $imageB->similar()->where('similar_image_id', $idA)->exists()) {
                $imageB->similar()->attach($idA);
            }
        }
    }
}
