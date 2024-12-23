<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/lang-ar', function() {
    session()->put('lang', 'ar');
    return back();
});

Route::get('/lang-en', function() {
    session()->put('lang', 'en');
    return back();
});
require __DIR__.'/auth.php';
Route::get('/explore', [PostController::class, 'explore'])->name('explore')->middleware('lang');
Route::get('/{user:username}', [UserController::class, 'index'])->name('user_profile')->middleware('lang');
Route::get('/{user:username}/edit', [UserController::class, 'edit'])->middleware(['lang', 'auth'])->name('edit_profile');
Route::patch('/{user:username}/update', [UserController::class, 'update'])->middleware(['lang', 'auth'])->name('update_profile');

Route::controller(PostController::class)->middleware(['lang', 'auth'])->group(function (){
    Route::get('/', 'index')->name('home_page');
    Route::get('/p/create', 'create')->name('create_post');
    Route::post('/p/create', 'store')->name('store_post');
    Route::get('/p/{post:slug}', 'show')->name('show_post');
    Route::get('/p/{post:slug}/edit', 'edit')->name('edit_post');
    Route::patch('/p/{post:slug}/update', 'update')->name('update_post');
    Route::delete('/p/{post:slug}/delete', 'destroy')->name('delete_post');
});

Route::get('/p/{post:slug}/like', LikeController::class)->middleware(['lang','auth']);
Route::get('/{user:username}/follow', [UserController::class, 'follow'])->middleware(['lang', 'auth'])->name('follow_user');
Route::get('/{user:username}/unfollow', [UserController::class, 'unfollow'])->middleware(['lang', 'auth'])->name('unfollow_user');




Route::post('/p/{post:slug}/comment', [CommentController::class, 'store'])->name('store_comment')->middleware(['lang', 'auth']);

