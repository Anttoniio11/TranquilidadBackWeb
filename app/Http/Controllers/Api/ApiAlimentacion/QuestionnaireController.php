<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\Request;


class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionnaire = Questionnaire::all();
        return response()->json($questionnaire);  
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
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'sexo' => 'required|in:masculino,femenino',
            'edad' => 'required|integer|min:1',
            'peso' => 'required|numeric|min:1',
            'altura' => 'required|numeric|min:1',
            'actividad_fisica' => 'required|in:sedentario,ligero,moderado,activo,muy_activo',
            'objetivo' => 'required|in:mantener_peso,perder_peso,ganar_peso',
            'trabajo' => 'required|in:oficina,moderado,fisico',
            'sueño' => 'required|in:menos_5h,5_6h,7_8h,mas_8h',
            'estres' => 'required|in:bajo,moderado,alto,muy_alto',
            'comida_rapida' => 'required|in:diario,varias_veces_semana,una_vez_semana,rara_vez',
            'frecuencia_comidas' => 'required|in:1_2_veces,3_4_veces,5_6_veces,mas_6_veces',
            'alcohol' => 'required|in:diario,varias_veces_semana,una_vez_semana,rara_vez',
            'condicion_medica' => 'nullable|string|max:255',
            'frutas_verduras' => 'required|in:todos_dias,4_6_veces_semana,2_3_veces_semana,1_vez_menos',
            'energia' => 'required|in:muy_alto,alto,moderado,bajo',
        ]);

        $validatedData = Questionnaire::create($request->all());
        return response()->json($validatedData);

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
    public function update(Request $request, Questionnaire $questionnaire)
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
            'energia' => 'required|in:muy_alto,alto,moderado,bajo'. $questionnaire->id,
        ]);

        $questionnaire->update($request->all());

        return response()->json($questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        $questionnaire->delete();
        return response()->json();
    }
}
