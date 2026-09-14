<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoriesController extends Controller
{
    public function index()
    {
        $cachedImages = Cache::get('category_images', []);

        $categories = Category::with('translations')->get()
            ->map(function (Category $category) use ($cachedImages) {
                if (isset($cachedImages[$category->slug])) {
                    $imageUrl = $cachedImages[$category->slug];
                } else {
                    $path = $category->images()->inRandomOrder()->value('path');
                    $imageUrl = $path ? Storage::disk('public')->url($path) : null;
                }

                return [
                    'slug'  => $category->slug,
                    'title' => $category->translation()?->title,
                    'image' => $imageUrl,
                ];
            })
            ->filter(fn($c) => $c['image'] !== null)
            ->values();

        return Inertia::render('Categories', [
            'appName'    => config('app.name'),
            'meta'       => [
                'title'       => __('common.seo.title'),
                'description' => __('common.seo.description'),
            ],
            'categories' => $categories,
        ]);
    }
}
