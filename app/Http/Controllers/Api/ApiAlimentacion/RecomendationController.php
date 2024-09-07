<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecommendationController extends Controller
{
    
    // Mostrar todos
    public function index(Request $request)
    {
        $recommendations = Recommendation::included()->filter()->sort()->getOrPaginate();
        return response()->json($recommendations);
    }

    // Crear
    public function store(Request $request)
    {
        $request->validate([
            'information' => 'required|string',
            'result_id' => 'required|exists:results,id',
        ]);

        $recommendation = Recommendation::create($request->all());

        return response()->json($recommendation, Response::HTTP_CREATED);
    }

    // Mostrar uno
    public function show($id)
    {
        $recommendation = Recommendation::included()->find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($recommendation);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'information' => 'string',
            'result_id' => 'exists:results,id',
        ]);

        $recommendation->update($request->all());

        return response()->json($recommendation);
    }

    // Eliminar
    public function destroy($id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        $recommendation->delete();

        return response()->json(['message' => 'Recommendation deleted successfully']);
    }
}
