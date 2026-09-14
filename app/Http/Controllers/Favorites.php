<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Favorites extends Controller
{
    public function index()
    {
        $likedSlugs = session('liked_images', []);

        $images = Image::with('translations')->whereIn('slug', $likedSlugs)->paginate(self::PAGINATE)->onEachSide(1)
            ->through(fn(Image $image) => [
                'slug'        => $image->slug,
                'src'         => $image->url,
                'caption'     => $image->translation()?->title,
                'description' => $image->translation()?->description,
                'views'       => $image->views,
                'likes'       => $image->likes,
                'liked'       => in_array($image->slug, $likedSlugs),
            ]);

        return Inertia::render('Welcome', [
            'appName' => config('app.name'),
            'meta' => [
                'title'       => __('common.seo.title'),
                'description' => __('common.seo.description'),
            ],
            'images' => $images,
        ]);
    }
}
