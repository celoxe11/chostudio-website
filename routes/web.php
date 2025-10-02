<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginPageController;
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
Route::get('/login', [LoginPageController::class, 'index'])->name('login');
Route::get('/home', [HomePageController::class, 'index'])->name('home');
