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
        $audios = Audio::all();
        return response()->json($audios);
    }

    // Crear un nuevo audio
    public function store(Request $request)
    {
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
    public function update(Request $request, $id)
    {
        $audio = Audio::findOrFail($id);
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
