<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    public function results (){
        return $this->hasMany(Result::class);
    }

    protected $fillable = ['sexo','edad','peso','altura','actividad_fisica','objetivo','trabajo','sueño','estres','comida_rapida','frecuencia_comidas','alcohol','condicion_medica','frutas_verduras','energia'];


}
