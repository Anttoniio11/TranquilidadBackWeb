<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // Listar todos los géneros
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres);
    }

    // Crear un nuevo género
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $genre = Genre::create($request->all());
        return response()->json($genre, 201);
    }

    // Mostrar un género específico
    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        return response()->json($genre);
    }

    // Actualizar un género existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $genre = Genre::findOrFail($id);
        $genre->update($request->all());
        return response()->json($genre);
    }

    // Eliminar un género
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        return response()->json(null, 204);
    }
}
