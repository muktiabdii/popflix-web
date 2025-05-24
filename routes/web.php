<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('home');
Route::get('/search', [MovieController::class, 'search'])->name('search');
Route::get('/filter-genre', [MovieController::class, 'filterByGenre'])->name('filter.genre');