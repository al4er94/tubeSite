<?php

namespace App\Http\Middleware;

use App\Http\Enums\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'locale'       => fn() => app()->getLocale(),
            'languages'    => Language::toArray(),
            'translations' => fn() => Arr::dot(require base_path("lang/" . app()->getLocale() . "/common.php")),
            'currentYear'  => now()->year,
            'categories'   => fn() => Category::with('translations')->get()
                ->map(fn(Category $category) => [
                    'slug'  => $category->slug,
                    'title' => $category->translation()?->title ?? $category->slug,
                ])->values(),
        ];
    }
}
