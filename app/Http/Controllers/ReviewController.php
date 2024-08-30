<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    // Mostrar todas las reseñas
    public function index(Request $request)
    {
        $reviews = Review::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($reviews);
    }

    // Mostrar una reseña específica
    public function show($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($review);
    }

    // Crear una nueva reseña
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|string',
            'comentario' => 'required|string',
            'calificacion' => 'required|string',
            'professional_id' => 'required|exists:professionals,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $review = Review::create($request->all());

        return response()->json($review, Response::HTTP_CREATED);
    }

    // Actualizar una reseña existente
    public function update(Request $request, $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'fecha' => 'string',
            'comentario' => 'string',
            'calificacion' => 'string',
            'professional_id' => 'exists:professionals,id',
            'patient_id' => 'exists:patients,id',
        ]);

        $review->update($request->all());

        return response()->json($review);
    }

    // Eliminar una reseña
    public function destroy($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
