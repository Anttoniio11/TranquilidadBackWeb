<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPlan extends Model
{
    use HasFactory;

    //recibe relacion uno a muchos healthPlans-recommendation
    public function recomendation (){
        return $this->belongsTo(Recommendation::class);
    }

    //manda relacion uno a muchos
    public function personalgoals (){
        return $this->belongsTo(PersonalGoal::class);
    }

    protected $fillable = ['pesoKg','pesoDeseadoKg','comidaHabitual','alturaCm','tipoMetabolismo'];


}
