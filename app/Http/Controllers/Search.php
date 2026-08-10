<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class Search extends Controller
{
    public function index(Request $request): Response
    {
        $query = trim($request->input('q', ''));

        $images = collect();
        $categories = collect();

        if ($query !== '') {
            $likedSlugs = session('liked_images', []);
            $like = '%' . $query . '%';

            $images = Image::with('translations')
                ->whereHas('translations', fn($q) => $q
                    ->where('title', 'LIKE', $like)
                    ->orWhere('description', 'LIKE', $like)
                )
                ->paginate(9)
                ->onEachSide(1)
                ->withQueryString()
                ->through(fn(Image $image) => [
                    'slug'        => $image->slug,
                    'src'         => $image->url,
                    'caption'     => $image->translation()?->title,
                    'description' => $image->translation()?->description,
                    'views'       => $image->views,
                    'likes'       => $image->likes,
                    'liked'       => in_array($image->slug, $likedSlugs),
                ]);

            $cachedImages = Cache::get('category_images', []);

            $categories = Category::with('translations')
                ->whereHas('translations', fn($q) => $q
                    ->where('title', 'LIKE', $like)
                    ->orWhere('description', 'LIKE', $like)
                )
                ->get()
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
        }

        return Inertia::render('Search', [
            'query'      => $query,
            'images'     => $images,
            'categories' => $categories,
            'meta'       => [
                'title'       => __('common.seo.title'),
                'description' => __('common.seo.description'),
            ],
        ]);
    }
}
