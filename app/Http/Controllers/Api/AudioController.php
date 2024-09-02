<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Audio;
use Illuminate\Http\Request;



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
        $request->validate([
            
            'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Para aceptar archivos de imagen
        'audio_file' => 'required|mimes:mp3,wav,aac|max:10000|unique:audios,audio_file', // Para aceptar archivos de audio específicos
        'duration' => 'required|integer',
        'genre_id' => 'required|exists:genres,id',
        'album_id' => 'nullable|exists:albums,id',
        'es_binaural' => 'required|boolean',
        'frecuencia' => 'required_if:es_binaural,true|nullable|numeric', // Solo requerida si es_binaural es true

        ]);

        // Subir la imagen si se proporciona
        $imageFilePath = $request->file('image_file')
            ? $request->file('image_file')->store('images/audios', 'public')
            : null;

        // Subir el archivo de audio
        $audioFilePath = $request->file('audio_file')->store('audios', 'public');

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
            'frecuencia' => $request->es_binaural ? $request->frecuencia : null, // Solo guarda la frecuencia si es_binaural es true
        ]);




        //$audio = Audio::create($request->all());

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
        

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'sometimes|required|mimes:mp3,wav,aac|max:10000|unique:audios,audio_file,' . $audio->id,
            'duration' => 'sometimes|required|integer',
            'genre_id' => 'sometimes|required|exists:genres,id',
            'album_id' => 'nullable|exists:albums,id',
            'es_binaural' => 'sometimes|required|boolean',
            'frecuencia' => 'required_if:es_binaural,true|nullable|numeric',
        ]);
    
        // Subir la imagen si se proporciona
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior si existe
            if ($audio->image_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($audio->image_file);
            }
    
            // Subir la nueva imagen
            $imageFilePath = $request->file('image_file')->store('images/audios', 'public');
            $audio->image_file = $imageFilePath;
        }
    
        // Subir el archivo de audio si se proporciona
        if ($request->hasFile('audio_file')) {
            // Eliminar el archivo de audio anterior si existe
            if ($audio->audio_file) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($audio->audio_file);
            }
    
            // Subir el nuevo archivo de audio
            $audioFilePath = $request->file('audio_file')->store('audios', 'public');
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
    
        $audio->save();
    
        return response()->json($audio, 200);

       
        
    }

    // Método para eliminar un audio
    public function destroy($id)
    {
        $audio = Audio::findOrFail($id); // Buscar el audio por ID o lanzar un error 404

        // Eliminar los archivos asociados (imagen y audio)
        if ($audio->image_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($audio->image_file);
        }
        if ($audio->audio_file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($audio->audio_file);
        }

        $audio->delete(); // Eliminar el registro del audio

        return response()->json(['message' => 'Audio eliminado exitosamente'], 200); // Responder con un mensaje de éxito
    }

    
}
