<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $questionnaireId)
    {
        // Encuentra el cuestionario que el usuario está realizando
        $questionnaire = Questionnaire::findOrFail($questionnaireId);

        // Si el usuario está autenticado, obtén su ID
        $userId = auth()->id();

        // Validar las respuestas del cuestionario (asume que las respuestas vienen en el request)
        $validatedData = $request->validate([
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'edad' => 'required|integer',
            // otros campos de validación aquí
        ]);

        // Cálculo de resultados como en tu lógica anterior (TMB, ajustes, etc.)
        $tmb = $this->calcularTMB($validatedData);
        $resultadoFinal = $this->ajustarResultados($tmb, $validatedData);

        // Crear el registro en 'results' asociando el usuario y el cuestionario
        $test = Result::create([
            'resultados' => $resultadoFinal,
            'user_id' => $userId,  // ID del usuario autenticado
            'questionnaire_id' => $questionnaire->id,  // ID del cuestionario realizado
        ]);

        // Devolver respuesta indicando que el test se guardó exitosamente
        return response()->json([
            'message' => 'Resultados del cuestionario guardados exitosamente',
            'resultados' => $resultadoFinal,
        ], 201);
    }

    protected function calcularTMB($data)
    {
        if ($data['sexo'] === 'masculino') {
            return 88.362 + (13.397 * $data['peso']) + (4.799 * $data['altura']) - (5.677 * $data['edad']);
        } else {
            return 447.593 + (9.247 * $data['peso']) + (3.098 * $data['altura']) - (4.330 * $data['edad']);
        }
    }

    protected function ajustarResultados($tmb, $data)
    {
        // Ajuste según la actividad física y otros factores
        $actividadFisica = match ($data['actividad_fisica']) {
            'sedentario' => 1.2,
            'ligero' => 1.375,
            'moderado' => 1.55,
            'activo' => 1.725,
            'muy_activo' => 1.9,
        };

        return $tmb * $actividadFisica;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
