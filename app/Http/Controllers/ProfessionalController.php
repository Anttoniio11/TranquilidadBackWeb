<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfessionalController extends Controller
{
    // Mostrar todos los profesionales
    public function index(Request $request)
    {
        $professionals = Professional::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($professionals);
    }

    // Mostrar un profesional específico
    public function show($id)
    {
        $professional = Professional::find($id);

        if (!$professional) {
            return response()->json(['message' => 'Professional not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($professional);
    }

    // Crear un nuevo profesional
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'edad' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|string',
            'departamento' => 'required|string',
            'municipio' => 'required|string',
            'direccion' => 'required|string',
            'tarjeta_profesional' => 'required|string',
            'experiencia' => 'required|string'
        ]);

        $professional = Professional::create($request->all());

        return response()->json($professional, Response::HTTP_CREATED);
    }

    // Actualizar un profesional existente
    public function update(Request $request, $id)
    {
        $professional = Professional::find($id);

        if (!$professional) {
            return response()->json(['message' => 'Professional not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'nullable|string',
            'apellido' => 'nullable|string',
            'edad' => 'nullable|string',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string',
            'departamento' => 'nullable|string',
            'municipio' => 'nullable|string',
            'direccion' => 'nullable|string',
            'tarjeta_profesional' => 'nullable|string',
            'experiencia' => 'nullable|string'
        ]);

        $professional->update($request->all());

        return response()->json($professional);
    }

    // Eliminar un profesional
    public function destroy($id)
    {
        $professional = Professional::find($id);

        if (!$professional) {
            return response()->json(['message' => 'Professional not found'], Response::HTTP_NOT_FOUND);
        }

        $professional->delete();

        return response()->json(['message' => 'Professional deleted successfully']);
    }
}
