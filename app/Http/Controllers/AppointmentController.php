<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    // Mostrar todas las citas
    public function index(Request $request)
    {
        $appointments = Appointment::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
        
        return response()->json($appointments);
    }

    // Mostrar una cita específica
    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($appointment);
    }

    // Crear una nueva cita
    public function store(Request $request)
    {
        $request->validate([
            'fecha_hora' => 'required|date_format:Y-m-d H:i:s',
            'estado' => 'required|string',
            'observacion' => 'nullable|string',
            'professional_id' => 'required|exists:professionals,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $appointment = Appointment::create($request->all());

        return response()->json($appointment, Response::HTTP_CREATED);
    }

    // Actualizar una cita existente
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'fecha_hora' => 'nullable|date_format:Y-m-d H:i:s',
            'estado' => 'nullable|string',
            'observacion' => 'nullable|string',
            'professional_id' => 'nullable|exists:professionals,id',
            'patient_id' => 'nullable|exists:patients,id',
        ]);

        $appointment->update($request->all());

        return response()->json($appointment);
    }

    // Eliminar una cita
    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], Response::HTTP_NOT_FOUND);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
