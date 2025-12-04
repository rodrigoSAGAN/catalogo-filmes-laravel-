<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Get the list of available genres
     */
    private function getGeneros()
    {
        return ['Terror', 'Drama', 'Comédia', 'Ação', 'Aventura', 'Infantil', 'Romântico'];
    }

    public function index(Request $request)
    {
        $query = Movie::query();
        $generos = $this->getGeneros();

        // Apply genre filter if provided
        if ($request->has('genero') && !empty($request->genero)) {
            $query->porGenero($request->genero);
        }

        // Apply author filter if provided
        if ($request->has('autor') && !empty($request->autor)) {
            $query->porAutor($request->autor);
        }

        $movies = $query->orderBy('sort_order')->get();

        // Check if view exists in movies.index or filmes.listar
        if (view()->exists('filmes.listar')) {
            return view('filmes.listar', compact('movies', 'generos'));
        }
        return view('movies.index', compact('movies', 'generos'));
    }

    public function create()
    {
        $generos = $this->getGeneros();

        if (view()->exists('filmes.criar')) {
            return view('filmes.criar', compact('generos'));
        }
        return view('movies.create', compact('generos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'release_year' => 'required|integer',
            'genre' => 'required',
            'image_url' => 'nullable|url',
            'user_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $data = $request->all();
        $data['is_series'] = $request->has('is_series');

        Movie::create($data);

        return redirect()->route('movies.index')
            ->with('success', 'Filme criado com sucesso.');
    }

    public function edit(Movie $movie)
    {
        $generos = $this->getGeneros();

        if (view()->exists('filmes.editar')) {
            return view('filmes.editar', compact('movie', 'generos'));
        }
        return view('movies.edit', compact('movie', 'generos'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title' => 'required',
            'release_year' => 'required|integer',
            'genre' => 'required',
            'image_url' => 'nullable|url',
            'user_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $data = $request->all();
        $data['is_series'] = $request->has('is_series');

        $movie->update($data);

        return redirect()->route('movies.index')
            ->with('success', 'Filme atualizado com sucesso');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Filme excluído com sucesso');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:movies,id',
        ]);

        foreach ($request->ids as $index => $id) {
            Movie::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
