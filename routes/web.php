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

Route::get('/', [HomePageController::class, 'index'])->name('home.index');
Route::get('/video/{id}', [Video::class, 'getVideo'])->name('video');

Route::get('/categories', [Categories::class, 'allCategories'])->name('allCategories');
Route::get('/categories/{id}', [Categories::class, 'videosByCategories'])->name('videosByCategories');

Route::get('/mostviews', [Categories::class, 'getMostView'])->name('getMostView');
Route::get('/toprated', [Categories::class, 'getTopRated'])->name('getTopRated');


//Admin panel routes
Route::get('/dashboard', [Admin::class, 'getAdminPanel'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/content', [Admin::class, 'getContent'])->middleware(['auth', 'verified'])->name('contents');
Route::get('/dashboard/content/{id}', [Admin::class, 'getVideoContent'])->middleware(['auth', 'verified'])->name('content');
Route::post('/dashboard/content/{id}', [Admin::class, 'updateVideoContent'])->middleware(['auth', 'verified'])->name('updateVideoContent');
Route::delete('/dashboard/content/{id}', [Admin::class, 'updateVideoContent'])->middleware(['auth', 'verified'])->name('dropVideoContent');


Route::get('/dashboard/users', [Admin::class, 'getUsers'])->middleware(['auth', 'verified'])->name('users');
Route::get('/dashboard/user/{id}', [Admin::class, 'getUser'])->middleware(['auth', 'verified'])->name('user');
Route::post('/dashboard/user/{id}', [Admin::class, 'updateUser'])->middleware(['auth', 'verified'])->name('updateUser');

Route::get('/dashboard/welcome', function (){
    return view('welcome');
})->middleware(['auth', 'verified'])->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
