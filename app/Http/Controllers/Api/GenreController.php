<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ->getOrPaginate();

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
            'description' => 'nullable|string',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subir la imagen
        $imageFile = $request->file('image_file');
        $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
        $imageFilePath = $imageFile->storeAs('images/genres', $imageName, 'public');

        //$imageFilePath = $request->file('image_file')->store('images/genres', 'public');

        // Crear el nuevo genre
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imageFilePath, // Almacenar la ruta de la imagen
        ]);


        //$genre = Genre::create($request->all());  //sin PNG
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
            'name' => 'sometimes|required|string|max:255|unique:genres,name,' . $genre->id, // Único excepto para el género actual
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subir la nueva imagen si se proporciona
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior si existe
            if ($genre->image_path && Storage::disk('public')->exists($genre->image_path)) {
                Storage::disk('public')->delete($genre->image_path);
            }

            // Subir la nueva imagen
            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFilePath = $imageFile->storeAs('images/genres', $imageName, 'public');
            $genre->image_path = $imageFilePath;
        }

        // Actualizar los otros datos del genero si se proporcionan
        if ($request->has('name')) {
            $genre->name = $request->name;
        }
        if ($request->has('description')) {
            $genre->description = $request->description;
        }

        $genre->save(); // Guardar los cambios

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
        // Eliminar la imagen del almacenamiento si existe
        if ($genre->image_path && Storage::disk('public')->exists($genre->image_path)) {
            Storage::disk('public')->delete($genre->image_path);
        }

        $genre->delete();
        return response()->json(['message' => 'Género eliminado exitosamente']);
    }
}
