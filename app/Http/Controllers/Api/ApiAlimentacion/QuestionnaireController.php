<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiAlimentacion\ResultController;


class QuestionnaireController extends Controller
{

    //lista
    public function index()
    {
        $questionnaire = Questionnaire::included()->get();
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
            'objetivo' => 'required|in:mantener peso,perder peso,ganar peso'
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
    public function update(Request $request, $id)
    {
        $questionnaire = Questionnaire::find($id);

        $request->validate([
            'genero' => 'in:masculino,femenino',
            'peso' => 'integer|min:1',
            'altura' => 'numeric|min:1',
            'edad' => 'numeric|min:1',
            'nivel_actividad' => 'in:sedentario,ligero,moderado,activo,muy activo',
            'tipo_trabajo' => 'in:sedentario,activo',
            'horas_dormidas' => 'integer|min:1',
            'nivel_estres' => 'in:bajo,moderado,alto',
            'frecuencia_comida_procesada' => 'in:baja,moderada,alta',
            'frecuencia_comidas' => 'integer|min:1',
            'consumo_alcohol' => 'in:ocasional,regular,no consume',
            'objetivo' => 'in:mantener peso,perder peso,ganar peso'
        ]);


        
        $questionnaire->update($request->all());
        return response()->json($questionnaire);
    }


    //elimina
    public function destroy($id)
    {
        $questionnaire = Questionnaire::find($id);
        $questionnaire->delete();
        return response()->json();
    }
}
