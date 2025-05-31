<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/search', [MovieController::class, 'search'])->name('search');
Route::get('/filter-genre', [MovieController::class, 'filterByGenre'])->name('filter.genre');

Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/watchlist', [WatchlistController::class, 'index'])->middleware('auth')->name('watchlist');
Route::post('/watchlist/add', [WatchlistController::class, 'add'])->middleware('auth')->name('watchlist.add');
Route::post('/watchlist/remove', [WatchlistController::class, 'remove'])->middleware('auth')->name('watchlist.remove');