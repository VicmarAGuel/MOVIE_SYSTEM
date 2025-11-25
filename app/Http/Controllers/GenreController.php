<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::withCount('movies')->get();
        return view('genre', compact('genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:genres,name',
            'description' => 'nullable',
        ]);

        Genre::create($request->all());

        return back()->with('success', 'New genre has been added.');
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|unique:genres,name,' . $genre->id,
            'description' => 'nullable',
        ]);

        $genre->update($request->all());

        return back()->with('success', 'Genre details updated.');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();

        return back()->with('success', 'Genre has been deleted.');
    }
}
