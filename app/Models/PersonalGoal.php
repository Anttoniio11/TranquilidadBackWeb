<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalGoal extends Model
{
    use HasFactory;

    //recibe relacion de uno a muchos
    public function healthplan (){
        return $this->belongsTo(HealthPlan::class);
    }

    //recibe relacion de uno a muchos
    public function processlog (){
        return $this->belongsTo(ProcessLog::class);
    }

}
