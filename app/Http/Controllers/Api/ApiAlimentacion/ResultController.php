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
    public function index()
    {
        $result = Result::all();
        return response()->json($result);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($idQ,$idU)
    {
        $validatedData = Questionnaire::find($idQ);
        $user = User::find($idU);

        // calcular el tmb segun el sexo
        if ($validatedData['sexo'] === 'masculino') {
            $tmb = 88.362 + (13.397 * $validatedData['peso']) + (4.799 * $validatedData['altura']) - (5.677 * $validatedData['edad']);
        } else {
            $tmb = 447.593 + (9.247 * $validatedData['peso']) + (3.098 * $validatedData['altura']) - (4.330 * $validatedData['edad']);
        }

        // ajustar tmb segun atividad fisica
        $actividadFisica = match ($validatedData['actividad_fisica']) {
            'sedentario' => 1.2,
            'ligero' => 1.375,
            'moderado' => 1.55,
            'activo' => 1.725,
            'muy_activo' => 1.9,
        };

        $tmbAjustado = $tmb * $actividadFisica;

        // segun respuestas Trabajo/Actividad Principal
        if ($validatedData['trabajo'] === 'fisico') {
            $tmbAjustado *= 1.1; // Aumenta si la actividad es fisica
        } elseif ($validatedData['trabajo'] === 'oficina') {
            $tmbAjustado *= 0.9; // baja si es sedentario
        }

        // sueño y estres
        if ($validatedData['sueño'] === 'menos_5h' || $validatedData['estres'] === 'muy_alto') {
            $tmbAjustado *= 0.95; // reduce el tmb si el sueño o estres es muy alto
        }

        // consumo de alimentos caloricos
        if ($validatedData['comida_rapida'] === 'diario') {
            $tmbAjustado *= 1.1; // aumenta la ingesta calorica
        }

        // frecuencia de comida
        if ($validatedData['frecuencia_comidas'] === '1_2_veces') {
            $tmbAjustado *= 0.9; // reduce el tmb si la respuesta es baja
        }

        // Consumo de Alcohol
        if ($validatedData['alcohol'] === 'diario') {
            $tmbAjustado *= 1.05; // aumenta si hay consumo de alcohol
        }

        // Ajustes finales
        $resultadoFinal = match ($validatedData['objetivo']) {
            'mantener_peso' => $tmbAjustado,
            'perder_peso' => $tmbAjustado * 0.85, // reduccion del 15% para perder peso
            'ganar_peso' => $tmbAjustado * 1.15, // aumento del 15% para perder peso
        };
    

        //$cuestion = Questionnaire::find(1); 
        //$user = User::find(1);
        //guardar
        //$test = $questionnaire->results()->create();
        $test = Result::create([
            'resultados' => $resultadoFinal,
            'questionnaire_id' => $validatedData->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Test guardado exitosamente',
            //'data' => $test->toArray(),
            'resultados' => $resultadoFinal
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'resultados'=> 'required',
            'questionnaire_id' => 'required',
            'user_id'=> 'required'
            ]);

        $validatedData = Result::create($request->all());
        return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Result::included()->findOrFail($id);
        return response()->json($result);
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
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'resultados'=> 'required',
            'questionnaire_id' => 'required',
            'user_id'=> 'required'
            ]);

        $result->update($request->all());

        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        $result->delete();
        return response()->json();
    }
}
