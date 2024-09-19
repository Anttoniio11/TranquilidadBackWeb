<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use App\Models\Result;
use App\Models\User;
use App\Services\ResultService;
use Illuminate\Http\Request;
use App\Services\ResultsService;
use App\Services\ResultsUpdateService;

class ResultController extends Controller
{

    protected $resultsService;
    protected $resultUpdateService;
    //lista
    public function index()
    {
        $result = Result::included()->filter()->sort()->getOrPaginate();
        return response()->json($result);
    }


    
    public function __construct(ResultsService $resultsService,ResultsUpdateService $resultsUpdateService)
    {
        $this->resultsService = $resultsService;
        $this->resultUpdateService = $resultsUpdateService;
    }

    //crear el resultdos de acuerdo a su user y cuestionario
    public function create($idU, $idQ)
    {
        $questionnaire = Questionnaire::find($idQ);
        $user = User::find($idU);

        $genero = $questionnaire->genero;
        $peso = $questionnaire->peso;
        $altura = $questionnaire->altura;
        $edad = $questionnaire->edad;
        $nivelActividad = $questionnaire->nivel_actividad;
        $tipoTrabajo = $questionnaire->tipo_trabajo;
        $horasDormidas = $questionnaire->horas_dormidas;
        $nivelEstres = $questionnaire->nivel_estres;
        $frecuenciaComidaProcesada = $questionnaire->frecuencia_comida_procesada;
        $frecuenciaComidas = $questionnaire->frecuencia_comidas;
        $consumoAlcohol = $questionnaire->consumo_alcohol;
        $objetivo = $questionnaire->objetivo;

        $resultado = $this->resultsService->calcularResultados($idQ, $idU, $genero, $peso, $altura, $edad, $nivelActividad, $tipoTrabajo, $horasDormidas, $nivelEstres, $frecuenciaComidaProcesada, $frecuenciaComidas, $consumoAlcohol, $objetivo);

        return $resultado;
    }

    //muestra informacion por id
    public function show(string $id)
    {
        $result = Result::included()->findOrFail($id);
        return response()->json($result);
    }


    public function edit(string $id)
    {
        //
    }


    //actualiza
    public function update($idU, $idQ, $idR)
    {

        $user = User::find($idU);
        $questionnaire = Questionnaire::find($idQ);
        $result = Result::find($idR);

        if (!$user || !$questionnaire || !$result) {
            return response()->json(['error' => 'Usuario, cuestionario o resultado no encontrado'], 404);
        }

        $genero = $questionnaire->genero;
        $peso = $questionnaire->peso;
        $altura = $questionnaire->altura;
        $edad = $questionnaire->edad;
        $nivelActividad = $questionnaire->nivel_actividad;
        $tipoTrabajo = $questionnaire->tipo_trabajo;
        $horasDormidas = $questionnaire->horas_dormidas;
        $nivelEstres = $questionnaire->nivel_estres;
        $frecuenciaComidaProcesada = $questionnaire->frecuencia_comida_procesada;
        $frecuenciaComidas = $questionnaire->frecuencia_comidas;
        $consumoAlcohol = $questionnaire->consumo_alcohol;
        $objetivo = $questionnaire->objetivo;

        $resultado = $this->resultUpdateService->calcularResultadosUpdate(
            $idR,
            $idQ,
            $idU,
            $genero,
            $peso,
            $altura,
            $edad,
            $nivelActividad,
            $tipoTrabajo,
            $horasDormidas,
            $nivelEstres,
            $frecuenciaComidaProcesada,
            $frecuenciaComidas,
            $consumoAlcohol,
            $objetivo
        );

        return $resultado;
    }


    //elimina
    public function destroy(Result $result)
    {
        $result->delete();
        return response()->json();
    }
}
