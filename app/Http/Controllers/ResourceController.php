<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'patient_id' => 'required|exists:patients,id'
        ]);

        $resource = Resource::create($request->all());

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
            'patient_id' => 'nullable|exists:patients,id'
        ]);

        $resource->update($request->all());

        return response()->json($resource);
    }

    // Eliminar un recurso
    public function destroy($id)
    {
        $resource = Resource::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        $resource->delete();

        return response()->json(['message' => 'Resource deleted successfully']);
    }
}
