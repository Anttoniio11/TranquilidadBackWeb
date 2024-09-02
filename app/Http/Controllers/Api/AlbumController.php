<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'required|string', // URL o ruta opcional
           
        ]);

        $album = Album::create($request->all());
        return response()->json($album,201);
    }

   
    public function show($id)
    {
        $album = Album::included()->findOrFail($id);
        return $album;
    }

    
    public function update(Request $request, Album $album)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|string',
            
        ]);

        $album->update($request->all());
        return response()->json($album);
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return response()->json($album);
        
    }
}
