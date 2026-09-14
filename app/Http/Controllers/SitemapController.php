<?php

namespace App\Http\Controllers;

use App\Http\Enums\Language;
use App\Models\Category;
use App\Models\Image;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create();
        $locales = array_column(Language::cases(), 'value');

        // Home pages for each locale
        foreach ($locales as $locale) {
            $sitemap->add(
                Url::create(route('welcome', ['locale' => $locale]))
                    ->setPriority(1.0)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            );
        }

        // Image pages for each locale
        $images = Image::all();
        foreach ($images as $image) {
            foreach ($locales as $locale) {
                $sitemap->add(
                    Url::create(route('video.show', ['locale' => $locale, 'slug' => $image->slug]))
                        ->setPriority(0.8)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($image->updated_at)
                );
            }
        }

        // Category pages for each locale
        $categories = Category::all();
        foreach ($categories as $category) {
            foreach ($locales as $locale) {
                $sitemap->add(
                    Url::create(route('category.show', ['locale' => $locale, 'slug' => $category->slug]))
                        ->setPriority(0.6)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($category->updated_at)
                );
            }
        }

        return $sitemap->toResponse(request());
    }
}
