<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        // Manejar la carga del archivo de imagen si está presente
        $imageFilePath = null;
        if ($request->hasFile('image_file')) {
            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension(); // Generar un nombre único y corto
            $imageFilePath = $imageFile->storeAs('images/audios', $imageName, 'public');
            //$imageFilePath = $request->file('image_file')->store('images/audios', 'public');
        }

        // Manejar la carga del archivo de audio
        $audioFile = $request->file('audio_file');
        $audioName = Str::random(10) . '.' . $audioFile->getClientOriginalExtension(); // Generar un nombre único y corto
        $audioFilePath = $audioFile->storeAs('audios', $audioName, 'public');

        //$audioFilePath = $request->file('audio_file')->store('audios', 'public');

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

    // Mostrar un audio específico
    public function show($id)
    {
        $audio = Audio::findOrFail($id);
        return response()->json($audio);
    }

    // Actualizar un audio existente
    public function update(Request $request, Audio $audio)
    {

        // Validar la solicitud
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Para aceptar archivos de imagen
            'audio_file' => 'nullable|mimes:mp3,wav,aac|max:10000|unique:audios,audio_file,' . $audio->id, // Para aceptar archivos de audio específicos
            'duration' => 'sometimes|required|integer',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'album_id' => 'nullable|exists:albums,id',
            'es_binaural' => 'sometimes|required|boolean',
            'frecuencia' => 'required_if:es_binaural,true|nullable|numeric', // Solo requerida si es_binaural es true
        ]);

        // Subir la nueva imagen si se proporciona
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior si existe
            if ($audio->image_file && Storage::disk('public')->exists($audio->image_file)) {
                Storage::disk('public')->delete($audio->image_file);
            }

            // Subir la nueva imagen
            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension(); // Generar un nombre único y corto
            $imageFilePath = $imageFile->storeAs('images/audios', $imageName, 'public');

            //$imageFilePath = $request->file('image_file')->store('images/audios', 'public');
            $audio->image_file = $imageFilePath;
        }

        // Subir el nuevo archivo de audio si se proporciona
        if ($request->hasFile('audio_file')) {
            // Eliminar el archivo de audio anterior si existe
            if ($audio->audio_file && Storage::disk('public')->exists($audio->audio_file)) {
                Storage::disk('public')->delete($audio->audio_file);
            }

            // Subir el nuevo archivo de audio
            $audioFile = $request->file('audio_file');
            $audioName = Str::random(10) . '.' . $audioFile->getClientOriginalExtension(); // Generar un nombre único y corto
            $audioFilePath = $audioFile->storeAs('audios', $audioName, 'public');
            //$audioFilePath = $request->file('audio_file')->store('audios', 'public');
            $audio->audio_file = $audioFilePath;
        }

        // Actualizar los datos del audio
        if ($request->has('title')) {
            $audio->title = $request->title;
        }
        if ($request->has('description')) {
            $audio->description = $request->description;
        }
        if ($request->has('duration')) {
            $audio->duration = $request->duration;
        }
        if ($request->has('genre_id')) {
            $audio->genre_id = $request->genre_id;
        }
        if ($request->has('album_id')) {
            $audio->album_id = $request->album_id;
        }
        if ($request->has('es_binaural')) {
            $audio->es_binaural = $request->es_binaural;
            $audio->frecuencia = $request->es_binaural ? $request->frecuencia : null;
        }

        $audio->save(); // Guardar los cambios

        return response()->json($audio, 200);
    }

    // Método para eliminar un audio
    public function destroy($id)
    {
        $audio = Audio::findOrFail($id); // Buscar el audio por ID o lanzar un error 404

        // Eliminar la imagen del almacenamiento si existe
        if ($audio->image_file && Storage::disk('public')->exists($audio->image_file)) {
            Storage::disk('public')->delete($audio->image_file);
        }

        // Eliminar el archivo de audio del almacenamiento si existe
        if ($audio->audio_file && Storage::disk('public')->exists($audio->audio_file)) {
            Storage::disk('public')->delete($audio->audio_file);
        }

        // Eliminar el registro del audio
        $audio->delete();

        return response()->json(['message' => 'Audio eliminado exitosamente'], 200);
    }
}
