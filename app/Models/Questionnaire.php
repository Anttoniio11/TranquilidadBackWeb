<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'genero',
        'peso',
        'altura',
        'edad',
        'nivel_actividad',
        'tipo_trabajo',
        'horas_dormidas',
        'nivel_estres',
        'frecuencia_comida_procesada',
        'frecuencia_comidas',
        'consumo_alcohol',
        'objetivo',
        'condicion_medica'
    ];

    //relacion uno a muchos con result
    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
