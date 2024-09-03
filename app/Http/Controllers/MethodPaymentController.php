<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MethodPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MethodPaymentController extends Controller
{
    // Mostrar todos los métodos de pago
    public function index(Request $request)
    {
        $methodPayments = MethodPayment::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($methodPayments);
    }

    // Mostrar un método de pago específico
    public function show($id)
    {
        $methodPayment = MethodPayment::find($id);

        if (!$methodPayment) {
            return response()->json(['message' => 'Method Payment not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($methodPayment);
    }

    // Crear un nuevo método de pago
    public function store(Request $request)
    {
        $request->validate([
            'medio' => 'required|string',
            'descripcion' => 'required|string',
            'importe' => 'required|string',
            'iva' => 'required|string',
            'bill_id' => 'required|exists:bills,id',
        ]);

        $methodPayment = MethodPayment::create($request->all());

        return response()->json($methodPayment, Response::HTTP_CREATED);
    }

    // Actualizar un método de pago existente
    public function update(Request $request, $id)
    {
        $methodPayment = MethodPayment::find($id);

        if (!$methodPayment) {
            return response()->json(['message' => 'Method Payment not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'medio' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'importe' => 'nullable|string',
            'iva' => 'nullable|string',
            'bill_id' => 'nullable|exists:bills,id',
        ]);

        $methodPayment->update($request->all());

        return response()->json($methodPayment);
    }

    // Eliminar un método de pago
    public function destroy($id)
    {
        $methodPayment = MethodPayment::find($id);

        if (!$methodPayment) {
            return response()->json(['message' => 'Method Payment not found'], Response::HTTP_NOT_FOUND);
        }

        $methodPayment->delete();

        return response()->json(['message' => 'Method Payment deleted successfully']);
    }
}
