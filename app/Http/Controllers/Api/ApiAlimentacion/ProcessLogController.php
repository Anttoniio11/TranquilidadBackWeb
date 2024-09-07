<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\ProcessLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProcessLogController extends Controller
{

    // Mostrar todos
    public function index(Request $request)
    {
        $processLogs = ProcessLog::included()->filter()->sort()->getOrPaginate();
        return response()->json($processLogs);
    }

    // Crear
    public function store(Request $request)
    {
        $request->validate([
            'registrationDate' => 'required|date',
            'forum_id' => 'required|exists:forums,id',
        ]);

        $processLog = ProcessLog::create($request->all());

        return response()->json($processLog, Response::HTTP_CREATED);
    }

    // Mostrar uno
    public function show($id)
    {
        $processLog = ProcessLog::included()->find($id);

        if (!$processLog) {
            return response()->json(['message' => 'ProcessLog not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($processLog);
    }

    // Actualizar
    public function update(Request $request, $id)
    {
        $processLog = ProcessLog::find($id);

        if (!$processLog) {
            return response()->json(['message' => 'ProcessLog not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'registrationDate' => 'date',
            'forum_id' => 'exists:forums,id',
        ]);

        $processLog->update($request->all());

        return response()->json($processLog);
    }

    // Eliminar
    public function destroy($id)
    {
        $processLog = ProcessLog::find($id);

        if (!$processLog) {
            return response()->json(['message' => 'ProcessLog not found'], Response::HTTP_NOT_FOUND);
        }

        $processLog->delete();

        return response()->json(['message' => 'ProcessLog deleted successfully']);
    }
}
 