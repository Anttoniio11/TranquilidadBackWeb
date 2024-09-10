<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Audio;
use Illuminate\Http\Request;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AudioController extends Controller
{

    // Listar todos los audios
    public function index()
    {
        $audios = Audio::included()
            ->filter()
            ->sort()
            ->getOrPaginate();


        return response()->json($audios);
    }

    // Crear un nuevo audio
    public function store(Request $request)
    {

        // Validar la solicitud
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'required|mimes:mp3,wav,aac|max:10000|unique:audios,audio_file',
            'duration' => 'required|integer',
            'genre_id' => 'required|exists:genres,id',
            'album_id' => 'nullable|exists:albums,id',
            'es_binaural' => 'required|boolean',
            'frecuencia' => 'required_if:es_binaural,true|nullable|numeric',
        ]);

        $imageFilePath = null;

        // Manejar la carga del archivo de imagen si está presente
        if ($request->hasFile('image_file')) {
            $imageFile = $request->file('image_file');

            // Verificar el tipo y estado del archivo
            if ($imageFile->isValid()) {
                try {
                    $uploadedImage = Cloudinary::upload($imageFile->getRealPath(), [
                        'folder' => 'audios/images',
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

        $audioFilePath = null;

        // Manejar la carga del archivo de audio
        if ($request->hasFile('audio_file')) {
            $audioFile = $request->file('audio_file');

            // Verificar el tipo y estado del archivo
            if ($audioFile->isValid()) {
                try {
                    // Cambiar a uploadVideo() para cargar correctamente archivos de audio
                    $uploadedAudio = Cloudinary::upload($audioFile->getRealPath(), [
                        'resource_type' => 'video',  // tipo de recurso = video ;aunque sea audio, solo asi lo puede entender Cloudinary
                        'folder' => 'audios/mp3',
                        'public_id' => Str::random(10)
                    ]);
                    $audioFilePath = $uploadedAudio->getSecurePath();
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to upload audio to Cloudinary: ' . $e->getMessage()], 400);
                }
            } else {
                return response()->json(['error' => 'Invalid audio file or file not valid'], 400);
            }
        }

        // Crear el nuevo registro de audio
        $audio = Audio::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_file' => $imageFilePath,
            'audio_file' => $audioFilePath,
            'duration' => $request->duration,
            'genre_id' => $request->genre_id,
            'album_id' => $request->album_id,
            'es_binaural' => $request->es_binaural,
            'frecuencia' => $request->es_binaural ? $request->frecuencia : null,
        ]);

        return response()->json($audio, 201);
    }

   
    public function show($id)
    {
        // Buscamos el audio por ID e incluimos las relaciones 
        $audio = Audio::with(['genre', 'album','tags','likes','histories','playlists'])  
            ->findOrFail($id);           // Devolvemos el audio o lanzamos un 404 si no se encuentra

        // Retornamos la respuesta en formato JSON con el audio y sus relaciones
        return response()->json($audio);
    }






    // Actualizar un audio existente
    public function update(Request $request,  $id)
    {
        // Validar la solicitud
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'image_file' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'sometimes|nullable|mimes:mp3,wav,aac|max:10000|unique:audios,audio_file,' . $id,
            'duration' => 'sometimes|required|integer',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'album_id' => 'sometimes|nullable|exists:albums,id',
            'es_binaural' => 'sometimes|required|boolean',
            'frecuencia' => 'sometimes|required_if:es_binaural,true|nullable|numeric',
        ]);

        // Encontrar el registro existente
        $audio = Audio::findOrFail($id);

        $imageFilePath = $audio->image_file;
        $audioFilePath = $audio->audio_file;

        // Manejar la carga del nuevo archivo de imagen si está presente
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior de Cloudinary si existe
            if ($imageFilePath) {
                $publicId = basename($imageFilePath, '.' . pathinfo($imageFilePath, PATHINFO_EXTENSION));
                Cloudinary::destroy('images/' . $publicId);
            }



            $imageFile = $request->file('image_file');
            if ($imageFile->isValid()) {
                try {
                    $uploadedImage = Cloudinary::upload($imageFile->getRealPath(), [
                        'folder' => 'images',
                        'public_id' => Str::random(10)
                    ]);
                    $imageFilePath = $uploadedImage->getSecurePath();
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to upload image to Cloudinary: ' . $e->getMessage()], 400);
                }
            }
        }

        // Manejar la carga del nuevo archivo de audio si está presente
        if ($request->hasFile('audio_file')) {
            // Eliminar el archivo de audio anterior de Cloudinary si existe
            if ($audioFilePath) {
                $publicId = basename($audioFilePath, '.' . pathinfo($audioFilePath, PATHINFO_EXTENSION));
                Cloudinary::destroy('audios/' . $publicId, ['resource_type' => 'video']);
            }

            $audioFile = $request->file('audio_file');
            if ($audioFile->isValid()) {
                try {
                    $uploadedAudio = Cloudinary::upload($audioFile->getRealPath(), [
                        'resource_type' => 'video',
                        'folder' => 'audios',
                        'public_id' => Str::random(10)
                    ]);
                    $audioFilePath = $uploadedAudio->getSecurePath();
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to upload audio to Cloudinary: ' . $e->getMessage()], 400);
                }
            }
        }
        // Preparar los datos para actualizar
        $dataToUpdate = $request->only([
            'title',
            'description',
            'duration',
            'genre_id',
            'album_id',
            'es_binaural',
            'frecuencia'
        ]);

        if ($request->has('image_file')) {
            $dataToUpdate['image_file'] = $imageFilePath;
        }

        if ($request->has('audio_file')) {
            $dataToUpdate['audio_file'] = $audioFilePath;
        }

        // Actualizar el registro en la base de datos
        $audio->update($dataToUpdate);

        return response()->json($audio, 200);
    }





    // Método para eliminar un audio
    public function destroy($id)
    {
        // Iniciar una transacción
        DB::beginTransaction();

        try {
            // Encontrar el registro existente
            $audio = Audio::findOrFail($id);

            // Eliminar el archivo de imagen en Cloudinary si existe
            if ($audio->image_file) {
                $publicId = basename($audio->image_file, '.' . pathinfo($audio->image_file, PATHINFO_EXTENSION));
                Cloudinary::destroy('images/' . $publicId);
            }

            // Eliminar el archivo de audio en Cloudinary si existe
            if ($audio->audio_file) {
                $publicId = basename($audio->audio_file, '.' . pathinfo($audio->audio_file, PATHINFO_EXTENSION));
                Cloudinary::destroy('audios/' . $publicId, ['resource_type' => 'video']);
            }

            // Eliminar el registro de la base de datos
            $audio->delete();

            // Confirmar la transacción
            DB::commit();

            return response()->json(['message' => 'Audio and associated files successfully deleted.'], 200);
        } catch (\Exception $e) {
            // Revertir la transacción
            DB::rollBack();

            return response()->json(['error' => 'Failed to delete audio and associated files: ' . $e->getMessage()], 400);
        }
    }
}
