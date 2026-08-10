<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheCategoryImages extends Command
{
    protected $signature = 'app:cache-category-images';

    protected $description = 'Cache a random preview image for each category';

    public function handle(): void
    {
        $data = Category::with('translations')->get()
            ->mapWithKeys(function (Category $category) {
                $path = $category->images()->inRandomOrder()->value('path');
                $image = $path ? \Illuminate\Support\Facades\Storage::disk('public')->url($path) : null;

                return [$category->slug => $image];
            })
            ->filter()
            ->all();

        Cache::put('category_images', $data, now()->addHours(2));

        $this->info('Cached images for ' . count($data) . ' categories.');
    }
}
