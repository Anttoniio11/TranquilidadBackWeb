<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\PersonalGoal;
use App\Models\Result;  
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\RecommendationsService;
use App\Services\RecommendationsUpdateService;

class RecommendationController extends Controller
{
    //instancioamos una variable la cual tendra las dependencias del service 
    protected $recommendationsUpadteService;
    protected $recommendationsService;
    public function __construct(RecommendationsService $recommendationsService,RecommendationsUpdateService $recommendationsUpadteService)
    {
        $this->recommendationsService = $recommendationsService;
        $this->recommendationsUpadteService = $recommendationsUpadteService;
    }
    ///////////////////////////////////////////////////////////////////////////////

    // Mostrar todos
    public function index(Request $request)
    {
        $recommendations = Recommendation::included()->filter()->sort()->getOrPaginate();
        return response()->json($recommendations);
    }

    public function create($idR){

        $result = Result::find($idR);

        $genero = $result->genero;
        $peso = $result->peso;
        $altura = $result->altura;
        $edad = $result->edad;
        $nivelActividad = $result->nivel_actividad;
        $tipoTrabajo = $result->tipo_trabajo;
        $horasDormidas = $result->horas_dormidas;
        $nivelEstres = $result->nivel_estres;
        $frecuenciaComidaProcesada = $result->frecuencia_comida_procesada;
        $frecuenciaComidas = $result->frecuencia_comidas;
        $consumoAlcohol = $result->consumo_alcohol;
        $objetivo = $result->objetivo;

        $recomendacion = $this->recommendationsService->calcularRecomendaciones($idR,$genero,$peso,$altura,$edad,$nivelActividad,$tipoTrabajo,$horasDormidas,$nivelEstres,$frecuenciaComidaProcesada,$frecuenciaComidas,$consumoAlcohol,$objetivo);

        return $recomendacion;
    }

    // Crear
    public function store(Request $request)
    {
        
        $request->validate([
            'information' => 'required|string',
            'result_id' => 'required|exists:results,id',
        ]);

        $recommendation = Recommendation::create($request->all());

        return response()->json($recommendation, Response::HTTP_CREATED);
    }

    // Mostrar uno
    public function show($id)
    {
        $recommendation = Recommendation::included()->find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($recommendation);
    }

    // Actualizar
    public function update($idRE,$idR)
    {
        $result = Result::find( $idR );
        $recommendation = Recommendation::find($idRE);

        if(!$result||!$recommendation) {
        return response()->json(['message'=> 'results or recommendations not found'], Response::HTTP_NOT_FOUND);
    }
    //falta completar actualizacion de recommendations 
}


    // Eliminar
    public function destroy($id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        $recommendation->delete();

        return response()->json(['message' => 'Recommendation deleted successfully']);
    }
}
