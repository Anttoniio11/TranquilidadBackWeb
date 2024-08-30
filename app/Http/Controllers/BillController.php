<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillController extends Controller
{
    // Mostrar todas las facturas
    public function index(Request $request)
    {
        $bills = Bill::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($bills);
    }

    // Mostrar una factura específica
    public function show($id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($bill);
    }

    // Crear una nueva factura
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $bill = Bill::create($request->all());

        return response()->json($bill, Response::HTTP_CREATED);
    }

    // Actualizar una factura existente
    public function update(Request $request, $id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        $bill->update($request->all());

        return response()->json($bill);
    }

    // Eliminar una factura
    public function destroy($id)
    {
        $bill = Bill::find($id);

        if (!$bill) {
            return response()->json(['message' => 'Bill not found'], Response::HTTP_NOT_FOUND);
        }

        $bill->delete();

        return response()->json(['message' => 'Bill deleted successfully']);
    }
}
