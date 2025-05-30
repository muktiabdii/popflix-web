<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
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

