<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfessionController extends Controller
{
    // Mostrar todas las profesiones
    public function index(Request $request)
    {
        $professions = Profession::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($professions);
    }

    // Mostrar una profesión específica
    public function show($id)
    {
        $profession = Profession::find($id);

        if (!$profession) {
            return response()->json(['message' => 'Profession not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($profession);
    }

    // Crear una nueva profesión
    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required|string',
            'lugar' => 'required|string',
            'duracion' => 'required|string',
            'descripcion' => 'required|string',
            'acta_grado' => 'required|string',
            'professional_id' => 'required|exists:professionals,id'
        ]);

        $profession = Profession::create($request->all());

        return response()->json($profession, Response::HTTP_CREATED);
    }

    // Actualizar una profesión existente
    public function update(Request $request, $id)
    {
        $profession = Profession::find($id);

        if (!$profession) {
            return response()->json(['message' => 'Profession not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nivel' => 'nullable|string',
            'lugar' => 'nullable|string',
            'duracion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'acta_grado' => 'nullable|string',
            'professional_id' => 'nullable|exists:professionals,id'
        ]);

        $profession->update($request->all());

        return response()->json($profession);
    }

    // Eliminar una profesión
    public function destroy($id)
    {
        $profession = Profession::find($id);

        if (!$profession) {
            return response()->json(['message' => 'Profession not found'], Response::HTTP_NOT_FOUND);
        }

        $profession->delete();

        return response()->json(['message' => 'Profession deleted successfully']);
    }
}
