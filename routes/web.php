<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/search', [MovieController::class, 'search'])->name('search');

// Filter dan detail movie
Route::get('/genre/{genreId}', [MovieController::class, 'filterByGenre'])->name('filter.genre');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('movie.show');

// Auth - Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Auth - Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Watchlist (butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist');
    Route::post('/watchlist/add', [WatchlistController::class, 'add'])->name('watchlist.add');
    Route::post('/watchlist/remove', [WatchlistController::class, 'remove'])->name('watchlist.remove');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});