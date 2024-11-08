<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Categories;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Video;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomePageController::class, 'index'])->name('home.index'); //old
Route::get('/public', [HomePageController::class, 'main'])->name('home.public');

Route::get('/video/{id}', [Video::class, 'getVideo'])->name('video');

Route::get('/categories_old', [Categories::class, 'allCategories'])->name('allCategories'); //old
Route::get('/categories', [Categories::class, 'getAllCategories'])->name('getAllCategories');

Route::get('/categories_old/{id}', [Categories::class, 'videosByCategories'])->name('videosByCategories'); //old
Route::get('/categories/{id}', [Categories::class, 'getVideosByCategories'])->name('getVideosByCategories');

Route::get('/mostviews_old', [Categories::class, 'getMostView'])->name('getMostView'); //old
Route::get('/mostviews', [Categories::class, 'getMostViewVideos'])->name('getMostViewVideos');

Route::get('/toprated_old', [Categories::class, 'getTopRated'])->name('getTopRated'); //old
Route::get('/toprated', [Categories::class, 'getTopRatedVideos'])->name('getTopRatedVideos');


//Admin panel routes
Route::get('/dashboard', [Admin::class, 'getAdminPanel'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard/content', [Admin::class, 'getContent'])->middleware(['auth', 'verified'])->name('contents');
Route::get('/dashboard/content/{id}', [Admin::class, 'getVideoContent'])->middleware(['auth', 'verified'])->name('content');
Route::post('/dashboard/content/{id}', [Admin::class, 'updateVideoContent'])->middleware(['auth', 'verified'])->name('updateVideoContent');
Route::delete('/dashboard/content/{id}', [Admin::class, 'updateVideoContent'])->middleware(['auth', 'verified'])->name('dropVideoContent');


Route::get('/dashboard/users', [Admin::class, 'getUsers'])->middleware(['auth', 'verified'])->name('users');
Route::get('/dashboard/user/{id}', [Admin::class, 'getUser'])->middleware(['auth', 'verified'])->name('user');
Route::post('/dashboard/user/{id}', [Admin::class, 'updateUser'])->middleware(['auth', 'verified'])->name('updateUser');

Route::get('/dashboard/categories', [Admin::class, 'getCategories'])->middleware(['auth', 'verified'])->name('categories');
Route::get('/dashboard/categories/{id}', [Admin::class, 'getCategory'])->middleware(['auth', 'verified'])->name('category');
Route::get('/dashboard/category', [Admin::class, 'createCategory'])->middleware(['auth', 'verified'])->name('categoryEmpty');
Route::post('/dashboard/category/{id}', [Admin::class, 'createCategory'])->middleware(['auth', 'verified'])->name('createCategoryPost');

Route::get('/dashboard/welcome', function (){
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
