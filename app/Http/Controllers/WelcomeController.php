<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    const CLICK_URL = 'https://leaked-girls.com';

    public function index(): Response
    {
        $likedSlugs = session('liked_images', []);

        $images = Image::with('translations')->paginate(self::PAGINATE)->onEachSide(1)
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

    public function show(Request $request): Response
    {
        $slug = $request->route('slug');

        $image = Image::with(['translations', 'categories.translations', 'similar.translations'])->where(Image::FIELD_SLUG, $slug)->firstOrFail();

        $image->increment('views');

        $likedSlugs = session('liked_images', []);

        $keywords = $image->translation()?->keywords ?? [];

        $similar = $image->similar->map(fn(Image $img) => [
            'slug'    => $img->slug,
            'src'     => $img->url,
            'caption' => $img->translation()?->title,
        ])->values();

        return Inertia::render('ImageDetail', [
            'image' => [
                'slug'        => $image->slug,
                'src'         => $image->url,
                'link'        => $image->link,
                'click_url'   => self::CLICK_URL,
                'caption'     => $image->translation()?->title,
                'description' => $image->translation()?->description,
                'keywords'    => $keywords,
                'views'       => $image->views,
                'likes'       => $image->likes,
                'liked'       => in_array($image->slug, $likedSlugs),
                'created_at'  => $image->created_at?->format('Y-m-d'),
                'categories'  => $image->categories->map(fn($cat) => [
                    'slug'  => $cat->slug,
                    'title' => $cat->translation()?->title,
                ])->values(),
                'similar'     => $similar,
            ],
            'meta' => [
                'title'       => $image->translation()?->title ?? __('common.seo.title'),
                'description' => $image->translation()?->description ?? __('common.seo.description'),
                'keywords'    => implode(', ', $keywords),
            ],
        ]);
    }

    public function video(Request $request): Response
    {
        $slug = $request->route('slug');

        $image = Image::with(['translations', 'categories.translations'])->where(Image::FIELD_SLUG, $slug)->firstOrFail();

        $keywords = $image->translation()?->keywords ?? [];

        return Inertia::render('Video', [
            'image' => [
                'slug'        => $image->slug,
                'src'         => $image->url,
                'caption'     => $image->translation()?->title,
                'description' => $image->translation()?->description,
                'keywords'    => $keywords,
                'views'       => $image->views,
                'likes'       => $image->likes,
                'created_at'  => $image->created_at?->format('Y-m-d'),
                'categories'  => $image->categories->map(fn($cat) => [
                    'slug'  => $cat->slug,
                    'title' => $cat->translation()?->title,
                ])->values(),
            ],
            'meta' => [
                'title'       => $image->translation()?->title ?? __('common.seo.title'),
                'description' => $image->translation()?->description ?? __('common.seo.description'),
                'keywords'    => implode(', ', $keywords),
            ],
        ]);
    }

    public function redirectById(Request $request): \Illuminate\Http\RedirectResponse
    {
        $id = $request->route('id');
        $locale = $request->route('locale');

        $image = Image::findOrFail($id);

        return redirect()->route('video.show', ['locale' => $locale, 'slug' => $image->slug], 301);
    }

    public function like(Request $request)
    {
        $slug = $request->route('slug');

        $image = Image::where(Image::FIELD_SLUG, $slug)->firstOrFail();

        $likedSlugs = session('liked_images', []);

        if (in_array($slug, $likedSlugs)) {
            $image->decrement(Image::FIELD_LIKES);

            session(['liked_images' => array_values(array_diff($likedSlugs, [$slug]))]);
        } else {
            $image->increment(Image::FIELD_LIKES);
            $likedSlugs[] = $slug;
            session(['liked_images' => $likedSlugs]);
        }

        return redirect()->back();
    }
}
