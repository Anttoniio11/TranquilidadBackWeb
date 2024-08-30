<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    
    public function index()
    {
        $podcast = Podcast::included()
                ->filter()
                ->sort()
                ->getOrPaginate();
        return response()->json($podcast);
    }

  
    public function store(Request $request)
    {
        $request->validate([
            
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:255',
            'duration' => 'required|integer',
        ]);

        // Crear el nuevo podcast
        $podcast = Podcast::create($request->all());

        return response()->json($podcast, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $podcast = Podcast::included()->findOrFail($id);
        return $podcast;
    }

    
    public function update(Request $request, Podcast $podcast)
    {
        $request->validate([
            
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:255',
            'duration' => 'required|integer',
        ]);

        $podcast->update($request->all());
        return response()->json($podcast);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Podcast $podcast)

    {
        $podcast->delete();
        return response()->json($podcast);
    }
}
