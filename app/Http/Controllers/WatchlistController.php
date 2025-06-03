<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use PDOException;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlist = Watchlist::where('user_id', Auth::id())->get();
        return view('watchlist', compact('watchlist'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'movie_title' => 'required|string|max:255',
            'poster_path' => 'nullable|string|max:255',
        ]);

        try {
            Watchlist::create([
                'user_id' => Auth::id(),
                'movie_id' => $request->movie_id,
                'movie_title' => $request->movie_title,
                'poster_path' => $request->poster_path,
            ]);

            return redirect()->back()->with('success', 'Movie added to watchlist!');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') { 
                return redirect()->back()->withErrors(['movie_id' => 'This movie is already in your watchlist.']);
            }
            throw $e;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { 
                return redirect()->back()->withErrors(['movie_id' => 'This movie is already in your watchlist.']);
            }
            throw $e;
        }
    }

    public function remove(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
        ]);

        Watchlist::where('user_id', Auth::id())
            ->where('movie_id', $request->movie_id)
            ->delete();

        return redirect()->back()->with('success', 'Movie removed from watchlist!');
    }
}