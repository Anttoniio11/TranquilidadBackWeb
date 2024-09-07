<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;


class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $info = Questionnaire::all();
        return response()->json($info);  
    }

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
        // Encuentra el cuestionario 
        $questionnaire = Questionnaire::findOrFail($questionnaireId);

        // Si el usuario esta autenticado
        //$userId = auth()->id();

        // Validar las respuestas 
        $validatedData = $request->validate([
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'edad' => 'required|integer',
            
        ]);

        // cal0culo de resultados
        $tmb = $this->calcularTMB($validatedData);
        $resultadoFinal = $this->ajustarResultados($tmb, $validatedData);

        // Crear el registro de results
        $test = Result::create([
            'resultados' => $resultadoFinal,
            //'user_id' => $userId,  // ID del usuario autenticado
            'questionnaire_id' => $questionnaire->id,  // id del cuestionario 
        ]);


        return response()->json([
            'message' => 'Guardados',
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
        // Ajuste según la actividad 
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
        $info = Questionnaire::included()->findOrFail($id);
        return response()->json($info);
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
    public function update(Request $request, Questionnaire $info)
    {
        $request->validate([
            'sexo' => 'required|in:masculino,femenino',
            'edad' => 'required|integer|min:1',
            'peso' => 'required|numeric|min:1',
            'altura' => 'required|numeric|min:1',
            'actividad_fisica' => 'required|in:sedentario,ligero,moderado,activo,muy_activo',
            'objetivo' => 'required|in:mantener_peso,perder_peso,ganar_peso',
            'trabajo' => 'required|in:oficina,moderado,fisico',
            'suenio' => 'required|in:menos_5h,5_6h,7_8h,mas_8h',
            'estres' => 'required|in:bajo,moderado,alto,muy_alto',
            'comida_rapida' => 'required|in:diario,varias_veces_semana,una_vez_semana,rara_vez',
            'frecuencia_comidas' => 'required|in:1_2_veces,3_4_veces,5_6_veces,mas_6_veces',
            'alcohol' => 'required|in:diario,varias_veces_semana,una_vez_semana,rara_vez',
            'condicion_medica' => 'nullable|string|max:255',
            'frutas_verduras' => 'required|in:todos_dias,4_6_veces_semana,2_3_veces_semana,1_vez_menos',
            'energia' => 'required|in:muy_alto,alto,moderado,bajo'. $info->id,
        ]);

        $info->update($request->all());

        return response()->json($info);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $info)
    {
        $info->delete();
        return response()->json();
    }
}
