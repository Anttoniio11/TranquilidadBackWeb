<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'resultados',
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
        'questionnaire_id',
        'user_id'
    ];


    //recibe relacion uno a muchos de user
    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }

    //recibe relacion uno a muchos de questionnaire
    public function questionnaire (){
        return $this->belongsTo(Questionnaire::class,'questionnaire_id');
    }

    //relacion uno a muchos con recommendation
    public function recommendations (){
        return $this->hasMany(Recommendation::class);
    }

    
}
