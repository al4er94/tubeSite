<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Category;
use App\Http\Controllers\Favorites;
use App\Http\Controllers\Popular;
use App\Http\Controllers\Search;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WelcomeController;
use App\Http\Enums\Language;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/', function () {
    return redirect('/' . (session('locale') ?? config('app.locale')));
});

Route::prefix('{locale}')
    ->middleware(SetLocale::class)
    ->whereIn('locale', array_column(Language::cases(), 'value'))
    ->group(function () {
        Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
        Route::get('/video/{slug}', [WelcomeController::class, 'show'])->name('video.show');
        Route::get('/video/{slug}/video', [WelcomeController::class, 'video'])->name('video.video');
        Route::post('/video/{slug}/like', [WelcomeController::class, 'like'])->name('video.like');
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/category/{slug}', [Category::class, 'index'])->name('category.show');
        Route::get('/favorites', [Favorites::class, 'index'])->name('favorites.show');
        Route::get('/popular', [Popular::class, 'index'])->name('popular.show');
        Route::get('/search', [Search::class, 'index'])->name('search');
        Route::get('/videos/{id}', [WelcomeController::class, 'redirectById'])->whereNumber('id');
    });
