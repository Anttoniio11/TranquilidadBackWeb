<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ResourceController extends Controller
{
    // Mostrar todos los recursos
    public function index(Request $request)
    {
        $resources = Resource::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($resources);
    }

    // Mostrar un recurso específico
    public function show($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($resource);
    }

    // Crear un nuevo recurso
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'professional_id' => 'required|exists:professionals,id',
            'patient_id' => 'required|exists:patients,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png|max:2048' // Validaciones del archivo
        ]);

        $data = $request->only(['nombre', 'descripcion', 'professional_id', 'patient_id']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'resources',
                'resource_type' => 'auto' // Permite subir diferentes tipos de archivos
            ]);
            $data['file_url'] = $uploadedFile->getSecurePath();
        }

        $resource = Resource::create($data);

        return response()->json($resource, Response::HTTP_CREATED);
    }

    // Actualizar un recurso existente
    public function update(Request $request, $id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'professional_id' => 'nullable|exists:professionals,id',
            'patient_id' => 'nullable|exists:patients,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png|max:2048' // Validaciones del archivo
        ]);

        $data = $request->only(['nombre', 'descripcion', 'professional_id', 'patient_id']);

        if ($request->hasFile('file')) {
            // Elimina el archivo anterior si existe
            if ($resource->file_url) {
                $publicId = basename(parse_url($resource->file_url, PHP_URL_PATH));
                Cloudinary::destroy($publicId);
            }

            $file = $request->file('file');
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'resources',
                'resource_type' => 'auto' // Permite subir diferentes tipos de archivos
            ]);
            $data['file_url'] = $uploadedFile->getSecurePath();
        }

        $resource->update($data);

        return response()->json($resource);
    }

    // Eliminar un recurso
    public function destroy($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        // Elimina el archivo de Cloudinary si existe
        if ($resource->file_url) {
            $publicId = basename(parse_url($resource->file_url, PHP_URL_PATH));
            Cloudinary::destroy($publicId);
        }

        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
