<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('posts', PostController::class);
    // Custom edit route for posts
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'updatePost'])->name('posts.update');
});


Route::get('/latest-posts', [PostController::class, 'latestPosts']);
Route::get('/trending-posts', [PostController::class, 'trending']);
Route::get('/entertainment-posts', [PostController::class, 'entertainment']);
Route::get('/sport-posts', [PostController::class, 'sport']);
Route::get('/religion-posts', [PostController::class, 'religion']);
Route::get('/politics-posts', [PostController::class, 'politics']);
Route::get('/education-posts', [PostController::class, 'education']);
Route::get('/business-posts', [PostController::class, 'business']);
Route::get('/finance-posts', [PostController::class, 'finance']);
Route::get('/world-posts', [PostController::class, 'world']);
Route::get('/view/{postId}', [PostController::class, 'show'])->name('posts.show');
Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');
Route::get('/donation', function () {
    return Inertia::render('Donation');
})->name('donation');
Route::get('/scholarship', function () {
    return Inertia::render('Scholarship');
})->name('scholarship');
Route::get('/suggestion', function () {
    return Inertia::render('Suggestion');
})->name('suggestion');
Route::get('/publish', function () {
    return Inertia::render('Publish');
})->name('publish');
