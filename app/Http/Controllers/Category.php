<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Category extends Controller
{
    public function index(Request $request) {
        $slug = $request->route('slug');

        $category = \App\Models\Category::with('translations')->where('slug', $slug)->firstOrFail();

        $images = $category->images()->with('translations')
            ->paginate(self::PAGINATE)->onEachSide(1)
            ->through(fn(Image $image) => [
                'slug'        => $image->slug,
                'src'         => $image->url,
                'caption'     => $image->translation()?->title,
                'description' => $image->translation()?->description,
                'views'       => $image->views,
                'likes'       => $image->likes,
            ]);

        $categoryTitle = $category->translation()?->title;

        return Inertia::render('Welcome', [
            'appName'       => config('app.name'),
            'categoryTitle' => $categoryTitle,
            'meta'          => [
                'title'       => $categoryTitle ?? __('common.seo.title'),
                'description' => __('common.seo.description'),
            ],
            'images' => $images,
        ]);
    }
}
