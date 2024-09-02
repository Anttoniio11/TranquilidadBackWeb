<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{

    public function index()
    {
        $albums = Album::included()
            ->filter()
            ->sort()
            ->getOrPaginate();

        return response()->json($albums);
    }


    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Subir la imagen
        $imageFile = $request->file('image_file');
        $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension(); // Generar un nombre único y corto
        $imageFilePath = $imageFile->storeAs('images/albums', $imageName, 'public');

        //$imageFilePath = $request->file('image_file')->store('images/albums', 'public');

        // Crear el nuevo álbum
        $album = Album::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imageFilePath, // Almacenar la ruta de la imagen
        ]);

        return response()->json($album, 201);
    }


    public function show($id)
    {
        $album = Album::included()->findOrFail($id);
        return $album;
    }


    public function update(Request $request, Album $album)
    {
        // Validar la solicitud
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para aceptar solo archivos de imagen
        ]);

        // Subir la nueva imagen si se proporciona
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior si existe
            if ($album->image_path && Storage::disk('public')->exists($album->image_path)) {
                Storage::disk('public')->delete($album->image_path);
            }

            // Subir la nueva imagen
            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension(); // Generar un nombre único y corto
            $imageFilePath = $imageFile->storeAs('images/albums', $imageName, 'public');
            $album->image_path = $imageFilePath;
        }

        // Actualizar los otros datos del álbum si se proporcionan
        if ($request->has('title')) {
            $album->title = $request->title;
        }
        if ($request->has('description')) {
            $album->description = $request->description;
        }

        $album->save(); // Guardar los cambios

        return response()->json($album);
    }

    public function destroy(Album $album)
    {

        // Eliminar la imagen del almacenamiento si existe
        if ($album->image_path && Storage::disk('public')->exists($album->image_path)) {
            Storage::disk('public')->delete($album->image_path);
        }

        $album->delete(); // Eliminar el registro del álbum

        return response()->json(['message' => 'Álbum eliminado exitosamente']);
    }
}
