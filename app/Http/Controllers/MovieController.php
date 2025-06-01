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
        ])->json()['results'] ?? [];

        // Fetch now playing movies
        $nowPlayingMovies = Http::get("{$baseUrl}/movie/now_playing", [
            'api_key' => $apiKey,
        ])->json()['results'] ?? [];

        // Fetch genres
        $genres = Http::get("{$baseUrl}/genre/movie/list", [
            'api_key' => $apiKey,
        ])->json()['genres'] ?? [];

        return view('home', compact('popularMovies', 'nowPlayingMovies', 'genres'));
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
        ])->json()['results'] ?? [];

        // Find the first YouTube trailer
        $trailer = collect($videos)->firstWhere('site', 'YouTube') ?? null;

        return view('movie-detail', compact('movie', 'trailer'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        if ($query) {
            $response = Http::get("{$baseUrl}/search/movie", [
                'api_key' => $apiKey,
                'query' => $query,
                'page' => $page,
            ])->json();

            $movies = $response['results'] ?? [];
            $totalResults = $response['total_results'] ?? 0;
            $totalPages = $response['total_pages'] ?? 1;

            $results = new \Illuminate\Pagination\LengthAwarePaginator(
                $movies,
                $totalResults,
                20,
                $page,
                ['path' => route('search'), 'query' => ['query' => $query]]
            );
        } else {
            $results = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        }

        return view('search', compact('results', 'query'));
    }

    public function filterByGenre(Request $request, $genre_id)
    {
        $genreId = $genre_id;
        $year = $request->input('year');
        $page = $request->input('page', 1);
        $apiKey = env('TMDB_API_KEY');
        $baseUrl = 'https://api.themoviedb.org/3';

        $genres = Http::get("{$baseUrl}/genre/movie/list", [
            'api_key' => $apiKey,
        ])->json()['genres'];
        $genreName = collect($genres)->firstWhere('id', $genreId)['name'] ?? 'Unknown Genre';

        $params = [
            'api_key' => $apiKey,
            'with_genres' => $genreId,
            'page' => $page,
        ];
        if ($year) {
            $params['primary_release_year'] = $year;
        }

        $response = Http::get("{$baseUrl}/discover/movie", $params)->json();

        $movies = $response['results'] ?? [];
        $totalResults = $response['total_results'] ?? 0;
        $totalPages = $response['total_pages'] ?? 1;

        $results = new \Illuminate\Pagination\LengthAwarePaginator(
            $movies,
            $totalResults,
            20,
            $page,
            ['path' => route('filter.genre', $genreId), 'query' => array_filter(['year' => $year])]
        );

        return view('genre', compact('results', 'genreId', 'genreName', 'year'));
    }
}