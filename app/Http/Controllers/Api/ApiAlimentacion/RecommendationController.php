<?php

namespace App\Http\Controllers\Api\ApiAlimentacion;

use App\Http\Controllers\Controller;
use App\Models\PersonalGoal;
use App\Models\Result;  
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiAlimentacion\ResultController;


class RecommendationController extends Controller
{
    
    // Mostrar todos
    public function index(Request $request)
    {
        $recommendations = Recommendation::included()->filter()->sort()->getOrPaginate();
        return response()->json($recommendations);
    }

    public function create($idR){

        $result = Result::find($idR);
        //$goal = PersonalGoal::find($idPG);


        generarRecomendaciones($caloriasTotales, $objetivo)
        {
            $recomendaciones = []

            if ($objetivo === 'mantener peso') {
                $recomendaciones[] = "Para mantener tu peso, deberías consumir aproximadamente $caloriasTotales calorías al día.";
            } elseif ($objetivo === 'perder peso') {
                $caloriasPerdida = $caloriasTotales * 0.85;
                $recomendaciones[] = "Para perder peso, considera reducir tu ingesta calórica a $caloriasPerdida calorías diarias.";
            } elseif ($objetivo === 'ganar peso') {
                $caloriasGanar = $caloriasTotales * 1.15;
                $recomendaciones[] = "Para ganar peso, deberías incrementar tu ingesta calórica a $caloriasGanar calorías diarias.";
            }

            if ($caloriasTotales > 3000) {
                $recomendaciones[] = "Tu consumo calórico es alto. Considera equilibrar tus comidas con más alimentos frescos y evitar alimentos procesados.";
            } elseif ($caloriasTotales < 1500) {
                $recomendaciones[] = "Tu consumo calórico es bajo. Asegúrate de no saltarte comidas y de incluir proteínas suficientes en tu dieta.";
            }

            return $recomendaciones;
            
        }
        

        // Obtener los datos del cuestionario
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

        // Validación de datos críticos
        if (is_null($genero) || is_null($peso) || is_null($altura) || is_null($edad)) {
            return response()->json(['message' => 'Datos incompletos para realizar el cálculo'], 400);
        }

        $tmb = calcularTMB($genero, $peso, $altura, $edad);

        // Ajustes por factores
        $caloriasTotales = ajustarPorActividad($tmb, $nivelActividad);
        $caloriasTotales = ajustarPorTrabajo($caloriasTotales, $tipoTrabajo);
        $caloriasTotales = ajustarPorSuenoEstres($caloriasTotales, $horasDormidas, $nivelEstres);
        $caloriasTotales = ajustarPorComidaProcesada($caloriasTotales, $frecuenciaComidaProcesada);
        $caloriasTotales = ajustarPorFrecuenciaComidas($caloriasTotales, $frecuenciaComidas);
        $caloriasTotales = ajustarPorAlcohol($caloriasTotales, $consumoAlcohol);

        // Redondear el resultado final
        $caloriasTotales = round($caloriasTotales, 2);

        // Generar recomendaciones basadas en el objetivo
        $recomendaciones = generarRecomendaciones($caloriasTotales, $objetivo);

        // Depurar para verificar las recomendaciones generadas
        if (empty($recomendaciones)) {
            return response()->json([
                'message' => 'No se generaron recomendaciones, revisa los datos',
                'caloriasTotales' => $caloriasTotales,
                'objetivo' => $objetivo,
                '',

            ], 400);
        }

        // Guardar resultado en la base de datos
        $recomendacionesJSON = json_encode($recomendaciones);
        $recommendation = Recommendation::create([
            'information' => $recomendacionesJSON,
            'result_id' => $result->id
        ]);


        if ($result) {
            return response()->json([
                'message' => 'Test guardado exitosamente',
                'resultados' => $caloriasTotales,
                'recomendaciones' => $recomendaciones
            ], 201);
        } else {
            return response()->json(['message' => 'Error al guardar el test'], 500);
        }




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
    public function update(Request $request, $id)
    {
        $recommendation = Recommendation::find($id);

        if (!$recommendation) {
            return response()->json(['message' => 'Recommendation not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'information' => 'string',
            'result_id' => 'exists:results,id',
        ]);

        $recommendation->update($request->all());

        return response()->json($recommendation);
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
