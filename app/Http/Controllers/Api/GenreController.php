<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Listar todos los géneros
    public function index()
    {
        $genres = Genre::included()
                ->filter()
                ->sort()
                ->getOrPaginate()
                ;
                        

        return response()->json($genres);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Crear un nuevo género
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string'
        ]);

        $genre = Genre::create($request->all());
        return response()->json($genre, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */

    // Mostrar un género específico
    public function show($id)
    {
        $genre = Genre::included()->findOrFail($id);
        return $genre;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */

    // Actualizar un género existente
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        
        $genre->update($request->all());
        return response()->json($genre);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */

    // Eliminar un género
    public function destroy(Genre $genre)
    {
      
        $genre->delete();
        return response()->json(null, 204);
    }
}
