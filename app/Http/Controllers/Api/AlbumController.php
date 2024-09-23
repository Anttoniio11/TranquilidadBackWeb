<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Manejar la carga del archivo de imagen
        $imageFilePath = null;
        if ($request->hasFile('image_file')) {
            $imageFile = $request->file('image_file');

            // Verificar que el archivo es válido
            if ($imageFile->isValid()) {
                try {
                    // Subir la imagen a Cloudinary
                    $uploadedImage = Cloudinary::upload($imageFile->getRealPath(), [
                        'folder' => 'albums/images',
                        'public_id' => Str::random(10)
                    ]);
                    $imageFilePath = $uploadedImage->getSecurePath(); // Obtener la URL segura de la imagen
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to upload image to Cloudinary: ' . $e->getMessage()], 400);
                }
            } else {
                return response()->json(['error' => 'Invalid image file or file not valid'], 400);
            }
        }

        // Crear el nuevo álbum
        $album = Album::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imageFilePath, // Almacenar la URL de la imagen
        ]);

        return response()->json($album, 201);
    }


    public function show($id)
    {
        $album = Album::included()
            ->filter()
            ->sort()
            ->findOrFail($id);
        return $album;
    }


    public function update(Request $request, $id)

    {
            // Validar la solicitud
    $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|nullable|string',
        'image_file' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Encontrar el álbum existente
    $album = Album::findOrFail($id);

    // Iniciar una transacción para asegurar la coherencia
    DB::beginTransaction();

    try {
        // Manejar la carga del nuevo archivo de imagen si está presente
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior de Cloudinary si existe
            if ($album->image_path) {
                $publicId = pathinfo(basename($album->image_path), PATHINFO_FILENAME);
                Cloudinary::destroy('albums/images/' . $publicId);
            }

            // Subir la nueva imagen a Cloudinary
            $imageFile = $request->file('image_file');
            if ($imageFile->isValid()) {
                $uploadedImage = Cloudinary::upload($imageFile->getRealPath(), [
                    'folder' => 'albums/images',
                    'public_id' => Str::random(10)
                ]);
                $album->image_path = $uploadedImage->getSecurePath(); // Actualizar la ruta de la nueva imagen
            } else {
                throw new \Exception('Invalid image file');
            }
        }

        // Actualizar los campos del álbum
        $album->title = $request->has('title') ? $request->title : $album->title;
        $album->description = $request->has('description') ? $request->description : $album->description;

        // Guardar los cambios en la base de datos
        $album->save();

        // Confirmar la transacción
        DB::commit();

        return response()->json($album, 200);

    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollBack();

        return response()->json(['error' => 'Failed to update album: ' . $e->getMessage()], 400);
    }

    }

    public function destroy($id)
    {
          // Iniciar una transacción
    DB::beginTransaction();

    try {
        // Encontrar el álbum existente
        $album = Album::findOrFail($id);

        // Eliminar la imagen en Cloudinary si existe
        if ($album->image_path) {
            // Extraer el public_id de la URL completa
            $publicId = pathinfo(basename($album->image_path), PATHINFO_FILENAME);
            Cloudinary::destroy('albums/images/' . $publicId);
        }

        // Eliminar el registro del álbum de la base de datos
        $album->delete();

        // Confirmar la transacción
        DB::commit();

        return response()->json(['message' => 'Album and associated image successfully deleted.'], 200);

    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollBack();

        return response()->json(['error' => 'Failed to delete album and associated image: ' . $e->getMessage()], 400);
    }

    }
}
