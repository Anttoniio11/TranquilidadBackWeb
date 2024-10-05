<?php

namespace App\Services;

use App\Models\Result;
use App\Models\Questionnaire;
use App\Models\User;

class ResultsService
{
    public function calcularResultados($idQ,$idU,$genero,$peso,$altura,$edad,$nivelActividad,$tipoTrabajo,$horasDormidas,$nivelEstres,$frecuenciaComidaProcesada,$frecuenciaComidas,$consumoAlcohol,$objetivo){ 
        
        $questionnaire = Questionnaire::find($idQ);
        $user = User::find($idU);

        if (!$questionnaire || !$user) {
            return response()->json(['message' => 'Datos no encontrados'], 404);
        }

        
        function calcularTMB($genero, $peso, $altura, $edad)
        {
            if ($genero === 'masculino') {
                return 88.362 + (13.397 * $peso) + (4.799 * $altura) - (5.677 * $edad);
            } else {
                return 447.593 + (9.247 * $peso) + (3.098 * $altura) - (4.330 * $edad);
            }
        }

        function ajustarPorActividad($tmb, $nivelActividad)
        {
            switch ($nivelActividad) {
                case 'sedentario':
                    return $tmb * 1.2;
                case 'ligero':
                    return $tmb * 1.375;
                case 'moderado':
                    return $tmb * 1.55;
                case 'activo':
                    return $tmb * 1.725;
                case 'muy activo':
                    return $tmb * 1.9;
                default:
                    return $tmb;
            }
        }

        function ajustarPorTrabajo($calorias, $tipoTrabajo)
        {
            if ($tipoTrabajo === 'sedentario') {
                return $calorias * 0.95;
            } elseif ($tipoTrabajo === 'activo') {
                return $calorias * 1.1;
            }
            return $calorias;
        }

        function ajustarPorSuenoEstres($calorias, $horasDormidas, $nivelEstres)
        {
            if ($horasDormidas < 6 || $nivelEstres === 'alto') {
                return $calorias * 0.95;
            }
            return $calorias;
        }

        function ajustarPorComidaProcesada($calorias, $frecuenciaComidaProcesada)
        {
            if ($frecuenciaComidaProcesada === 'alta') {
                return $calorias * 1.1;
            }
            return $calorias;
        }

        function ajustarPorFrecuenciaComidas($calorias, $frecuenciaComidas)
        {
            if ($frecuenciaComidas < 3) {
                return $calorias * 0.9;
            }
            return $calorias;
        }

        function ajustarPorAlcohol($calorias, $consumoAlcohol)
        {
            if ($consumoAlcohol === 'regular') {
                return $calorias + 200;
            }
            return $calorias;
        }

        function generarRecomendaciones($caloriasTotales, $objetivo)
        {
            $recomendaciones = [];

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
        $result = Result::create([
            'resultados' => $caloriasTotales,
            'genero' => $genero,
            'peso' => $peso,
            'altura' => $altura,
            'edad' => $edad,
            'nivel_actividad' => $nivelActividad,
            'tipo_trabajo' => $tipoTrabajo,
            'horas_dormidas' => $horasDormidas,
            'nivel_estres' => $nivelEstres,
            'frecuencia_comida_procesada' => $frecuenciaComidaProcesada,
            'frecuencia_comidas' => $frecuenciaComidas,
            'consumo_alcohol' => $consumoAlcohol,
            'objetivo' => $objetivo,
            'recomendaciones'  => $recomendaciones,
            'questionnaire_id' => $idQ,
            'user_id' => $idU            
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
}