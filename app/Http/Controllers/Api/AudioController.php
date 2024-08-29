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
                ->getOrPaginate()
                ;
                        

        return response()->json($audios);
    }

    // Crear un nuevo audio
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'binaural_sound_id' => 'required|exists:binaural_sounds,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'file_path' => 'required|string',
            'description' => 'nullable|string|max:1000',
            
        ]);

        $audio = Audio::create($request->all());

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
            'duration' => 'sometimes|required|integer|min:1',
            'binaural_sound_id' => 'sometimes|required|exists:binaural_sounds,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'file_path' => 'sometimes|required|string',
            'description' => 'nullable|string|max:1000',
            
        ]);
        $audio->update($request->all());
        return response()->json($audio);
    }

    // Eliminar un audio
    public function destroy($id)
    {
        $audio = Audio::findOrFail($id);
        $audio->delete();
        return response()->json(null, 204);
    }
    
}
