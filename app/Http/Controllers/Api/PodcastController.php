<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        // Validar la solicitud
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Acepta archivos de imagen
            'video_file' => 'required|mimes:mp4,mov,ogg,qt|max:20000|unique:podcasts,video_file', // Acepta archivos de video específicos
            'duration' => 'required|integer',
        ]);

        // Subir la imagen si se proporciona
        $imageFilePath = null;


        if ($request->hasFile('image_file')) {

            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension(); // Nombre corto y único
            $imageFilePath = $imageFile->storeAs('images/podcasts', $imageName, 'public');



            //$imageFilePath = $request->file('image_file')->store('images/podcasts', 'public');
        }

        // Subir el archivo de video
        $videoFile = $request->file('video_file');
        $videoName = Str::random(10) . '.' . $videoFile->getClientOriginalExtension(); // Nombre corto y único
        $videoFilePath = $videoFile->storeAs('videos/podcasts', $videoName, 'public');


        //$videoFilePath = $request->file('video_file')->store('videos/podcasts', 'public');

        // Crear el nuevo podcast
        $podcast = Podcast::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_file' => $imageFilePath,
            'video_file' => $videoFilePath,
            'duration' => $request->duration,
        ]);

        return response()->json($podcast, 201);
    }


    public function update(Request $request, Podcast $podcast)
    {

        // Validar la solicitud
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Acepta archivos de imagen
            'video_file' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000|unique:podcasts,video_file,' . $podcast->id, // Acepta archivos de video específicos
            'duration' => 'sometimes|required|integer',
        ]);

        // Subir la nueva imagen si se proporciona
        if ($request->hasFile('image_file')) {
            // Eliminar la imagen anterior si existe
            if ($podcast->image_file && Storage::disk('public')->exists($podcast->image_file)) {
                Storage::disk('public')->delete($podcast->image_file);
            }



            // Subir la nueva imagen

            $imageFile = $request->file('image_file');
            $imageName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFilePath = $imageFile->storeAs('images/podcasts', $imageName, 'public');


            // $imageFilePath = $request->file('image_file')->store('images/podcasts', 'public');
            $podcast->image_file = $imageFilePath;
        }

        // Subir el nuevo archivo de video si se proporciona
        if ($request->hasFile('video_file')) {
            // Eliminar el archivo de video anterior si existe
            if ($podcast->video_file && Storage::disk('public')->exists($podcast->video_file)) {
                Storage::disk('public')->delete($podcast->video_file);
            }

            // Subir el nuevo archivo de video
            $videoFile = $request->file('video_file');
            $videoName = Str::random(10) . '.' . $videoFile->getClientOriginalExtension();
            $videoFilePath = $videoFile->storeAs('videos/podcasts', $videoName, 'public');

            //$videoFilePath = $request->file('video_file')->store('videos/podcasts', 'public');
            $podcast->video_file = $videoFilePath;
        }

        // Actualizar los datos del podcast si se proporcionan
        if ($request->has('title')) {
            $podcast->title = $request->title;
        }
        if ($request->has('description')) {
            $podcast->description = $request->description;
        }
        if ($request->has('duration')) {
            $podcast->duration = $request->duration;
        }

        $podcast->save(); // Guardar los cambios

        return response()->json($podcast, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Podcast $podcast)

    {
        // Eliminar la imagen del almacenamiento si existe
        if ($podcast->image_file && Storage::disk('public')->exists($podcast->image_file)) {
            Storage::disk('public')->delete($podcast->image_file);
        }

        // Eliminar el archivo de video del almacenamiento si existe
        if ($podcast->video_file && Storage::disk('public')->exists($podcast->video_file)) {
            Storage::disk('public')->delete($podcast->video_file);
        }

        // Eliminar el registro del podcast
        $podcast->delete();

        return response()->json(['message' => 'Podcast eliminado exitosamente'], 200);
    }
}
