<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\PersonalGoal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersonalGoalController extends Controller
{
    // Mostrar todos
    public function index(Request $request)
    {
        $personalGoals = PersonalGoal::included()->filter()->sort()->getOrPaginate();
        return response()->json($personalGoals);
    }

    // Mostrar uno
    public function show($id)
    {
        $personalGoal = PersonalGoal::included()->find($id);

        if (!$personalGoal) {
            return response()->json(['message' => 'PersonalGoal not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($personalGoal);
    }

    // Crear
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'healthPlan_id' => 'required|exists:health_plans,id',
            'processLog_id' => 'required|exists:process_logs,id',
        ]);

        $personalGoal = PersonalGoal::create($request->all());

        return response()->json($personalGoal, Response::HTTP_CREATED);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $personalGoal = PersonalGoal::find($id);

        if (!$personalGoal) {
            return response()->json(['message' => 'PersonalGoal not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'description' => 'string',
            'healthPlan_id' => 'exists:health_plans,id',
            'processLog_id' => 'exists:process_logs,id',
        ]);

        $personalGoal->update($request->all());

        return response()->json($personalGoal);
    }

    // Eliminar
    public function destroy($id)
    {
        $personalGoal = PersonalGoal::find($id);

        if (!$personalGoal) {
            return response()->json(['message' => 'PersonalGoal not found'], Response::HTTP_NOT_FOUND);
        }

        $personalGoal->delete();

        return response()->json(['message' => 'PersonalGoal deleted successfully']);
    }
}
