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

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $page = $request->input('page', 1);
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        $response = Http::get("{$baseUrl}/search/movie", [
            'api_key' => $apiKey,
            'query' => $query,
            'page' => $page,
        ])->json();

        $movies = $response['results'] ?? [];
        $totalResults = $response['total_results'] ?? 0;
        $totalPages = $response['total_pages'] ?? 1;

        // Create a LengthAwarePaginator instance for Laravel pagination
        $results = new \Illuminate\Pagination\LengthAwarePaginator(
            $movies,
            $totalResults,
            20, // TMDb returns 20 results per page
            $page,
            ['path' => route('search'), 'query' => ['query' => $query]]
        );

        return view('search', compact('results', 'query'));
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