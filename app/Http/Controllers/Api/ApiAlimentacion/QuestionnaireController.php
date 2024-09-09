<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\Request;


class QuestionnaireController extends Controller
{

    //lista
    public function index()
    {
        $questionnaire = Questionnaire::all();
        return response()->json($questionnaire);  
    }


    public function create()
    {
        //
    }


    //crea
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $questionnaire = $request->validate([
            'genero' => 'required|in:masculino,femenino',
            'peso' => 'required|integer|min:1',
            'altura' => 'required|numeric|min:1',
            'edad' => 'required|numeric|min:1',
            'nivel_actividad' => 'required|in:sedentario,ligero,moderado,activo,muy activo',
            'tipo_trabajo' => 'required|in:sedentario,activo',
            'horas_dormidas' => 'required|integer|min:1',
            'nivel_estres' => 'required|in:bajo,moderado,alto',
            'frecuencia_comida_procesada' => 'required|in:baja,moderada,alta',
            'frecuencia_comidas' => 'required|integer|min:1',
            'consumo_alcohol' => 'required|in:ocasional,regular,no consume',
            'objetivo' => 'required|in:mantener peso,perder peso,ganar peso',
            'condicion_medica' => 'nullable|string|max:255',
        ]);

        $questionnaire = Questionnaire::create($request->all());
        return response()->json($questionnaire);

    }


    //muestra informacion por id
    public function show(string $id)
    {
        $info = Questionnaire::included()->findOrFail($id);
        return response()->json($info);
    }



    public function edit(string $id)
    {
        //
    }


    //actualiza
    public function update(Request $request, Questionnaire $questionnaire)
    {
        $request->validate([
            'genero' => 'required|in:masculino,femenino',
            'peso' => 'required|integer|min:1',
            'altura' => 'required|numeric|min:1',
            'edad' => 'required|numeric|min:1',
            'nivel_actividad' => 'required|in:sedentario,ligero,moderado,activo,muy_activo',
            'tipo_trabajo' => 'required|in:sedentario,activo',
            'horas_dormidas' => 'required|integer|min:1',
            'nivel_estres' => 'required|in:bajo,moderado,alto',
            'frecuencia_comida_procesada' => 'required|in:baja,moderada,alta',
            'frecuencia_comidas' => 'required|integer|min:1',
            'consumo_alcohol' => 'required|in:ocasional,regular,no_consume',
            'objetivo' => 'required|in:mantener_peso,perder_peso,ganar_peso',
            'condicion_medica' => 'nullable|string|max:255', $questionnaire->id,
        ]);

        $questionnaire->update($request->all());

        return response()->json($questionnaire);
    }


    //elimina
    public function destroy(Questionnaire $questionnaire)
    {
        $questionnaire->delete();
        return response()->json();
    }
}
