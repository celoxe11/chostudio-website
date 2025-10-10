<?php

use App\Http\Controllers\ArtistCommisionController;
use App\Http\Controllers\GalleryPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LoginPageController;
use App\Http\Controllers\ArtistGalleryController;
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

Route::get('/', function () {
    return view('starting');
});
Route::get('/login', [LoginPageController::class, 'login'])->name('login');
Route::get('/register', [LoginPageController::class, 'register'])->name('register');
Route::get('/home', [HomePageController::class, 'index'])->name('home');
Route::get('/gallery', [GalleryPageController::class, 'index'])->name('gallery');

// Artist Routes
// TODO: Kasih middleware nanti
Route::prefix('artist')->group(function () {
    Route::get('/commisions', [ArtistCommisionController::class, 'index'])->name('artist.commisions');
    Route::get('/gallery', [ArtistGalleryController::class, 'index'])->name('artist.gallery');
});
