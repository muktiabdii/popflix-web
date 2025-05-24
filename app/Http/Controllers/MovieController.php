<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        // Fetch popular movies
        $popularMovies = Http::get("{$baseUrl}/movie/popular", [
            'api_key' => $apiKey,
        ])->json()['results'];

        // Fetch now playing movies
        $nowPlayingMovies = Http::get("{$baseUrl}/movie/now_playing", [
            'api_key' => $apiKey,
        ])->json()['results'];

        // Fetch genres
        $genres = Http::get("{$baseUrl}/genre/movie/list", [
            'api_key' => $apiKey,
        ])->json()['genres'];

        return view('welcome', compact('popularMovies', 'nowPlayingMovies', 'genres'));
    }

    public function show($id)
    {
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        // Fetch movie details
        $movie = Http::get("{$baseUrl}/movie/{$id}", [
            'api_key' => $apiKey,
        ])->json();

        // Fetch movie videos (for trailer)
        $videos = Http::get("{$baseUrl}/movie/{$id}/videos", [
            'api_key' => $apiKey,
        ])->json()['results'];

        // Find the first YouTube trailer
        $trailer = collect($videos)->firstWhere('site', 'YouTube') ?? null;

        return view('movie-detail', compact('movie', 'trailer'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        $results = Http::get("{$baseUrl}/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
        ])->json()['results'];

        return response()->json($results);
    }

    public function filterByGenre(Request $request)
    {
        $genreId = $request->input('genre_id');
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        $results = Http::get("{$baseUrl}/discover/movie", [
            'api_key' => $apiKey,
            'with_genres' => $genreId,
        ])->json()['results'];

        return response()->json($results);
    }
}