<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    // Mostrar todos los pacientes
    public function index(Request $request)
    {
        $patients = Patient::query()
            ->included()  // Aplicar relación incluida
            ->filter()     // Aplicar filtros
            ->sort()       // Aplicar ordenamiento
            ->getOrPaginate(); // Obtener o paginar resultados
        
        return response()->json($patients);
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($patient);
    }

    // Crear un nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'edad' => 'required|string',
            'correo' => 'required|string',
            'telefono' => 'required|string',
            'departamento' => 'required|string',
            'municipio' => 'required|string',
            'direccion' => 'required|string'
        ]);

        $patient = Patient::create($request->all());

        return response()->json($patient);
    }

    // Actualizar un paciente existente
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'nullable|string',
            'apellido' => 'nullable|string',
            'edad' => 'nullable|string',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string',
            'departamento' => 'nullable|string',
            'municipio' => 'nullable|string',
            'direccion' => 'nullable|string'
        ]);

        $patient->update($request->all());

        return response()->json($patient);
    }

    // Eliminar un paciente
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], Response::HTTP_NOT_FOUND);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
