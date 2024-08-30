<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankController extends Controller
{
    // Mostrar todos los bancos
    public function index(Request $request)
    {
        $banks = Bank::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($banks);
    }

    // Mostrar un banco específico
    public function show($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json(['message' => 'Bank not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($bank);
    }

    // Crear un nuevo banco
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'sucursal' => 'required|string',
            'direccion' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
            'bill_id' => 'required|exists:bills,id',
        ]);

        $bank = Bank::create($request->all());

        return response()->json($bank, Response::HTTP_CREATED);
    }

    // Actualizar un banco existente
    public function update(Request $request, $id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json(['message' => 'Bank not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'nullable|string',
            'sucursal' => 'nullable|string',
            'direccion' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
            'bill_id' => 'nullable|exists:bills,id',
        ]);

        $bank->update($request->all());

        return response()->json($bank);
    }

    // Eliminar un banco
    public function destroy($id)
    {
        $bank = Bank::find($id);

        if (!$bank) {
            return response()->json(['message' => 'Bank not found'], Response::HTTP_NOT_FOUND);
        }

        $bank->delete();

        return response()->json(['message' => 'Bank deleted successfully']);
    }
}
