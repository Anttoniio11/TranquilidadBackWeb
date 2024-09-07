<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\HealthPlan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HealthPlanController extends Controller
{
    // Mostrar todos
    public function index(Request $request)
    {
        $healthPlans = HealthPlan::included()->filter()->sort()->getOrPaginate();
        return response()->json($healthPlans);
    }

    // Mostrar uno
    public function show($id)
    {
        $healthPlan = HealthPlan::included()->find($id);

        if (!$healthPlan) {
            return response()->json(['message' => 'HealthPlan not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($healthPlan);
    }

    // Crear
    public function store(Request $request)
    {
        $request->validate([
            'pesoKg' => 'required|integer',
            'pesoDeseadoKg' => 'required|integer',
            'comidaHabitual' => 'required|string',
            'alturaCm' => 'required|string',
            'tipoMetabolismo' => 'required|string',
        ]);

        $healthPlan = HealthPlan::create($request->all());

        return response()->json($healthPlan, Response::HTTP_CREATED);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $healthPlan = HealthPlan::find($id);

        if (!$healthPlan) {
            return response()->json(['message' => 'HealthPlan not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'pesoKg' => 'integer',
            'pesoDeseadoKg' => 'integer',
            'comidaHabitual' => 'string',
            'alturaCm' => 'string',
            'tipoMetabolismo' => 'string',
        ]);

        $healthPlan->update($request->all());

        return response()->json($healthPlan);
    }

    // Eliminar
    public function destroy($id)
    {
        $healthPlan = HealthPlan::find($id);

        if (!$healthPlan) {
            return response()->json(['message' => 'HealthPlan not found'], Response::HTTP_NOT_FOUND);
        }

        $healthPlan->delete();

        return response()->json(['message' => 'HealthPlan deleted successfully']);
    }
}
