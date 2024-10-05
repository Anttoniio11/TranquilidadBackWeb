<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    //relacion de uno a muchos con result
    public function results(){
        return $this->hasMany(Result::class);
    }
    
    //recibe relacion de unos a muchos con user
    public function user(){
        return $this->belongsTo(User::class);
    }

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

    //posibles querys
    protected $allowIncluded = ['results','results.recommendations','results.user'];

    //scope para relaciones anidadas 
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

}
