<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    //recibe relacion uno a muchos recommendations-result
    public function result (){
        return $this->belongsTo(Result::class);
    }

    //relacion uno a muchos recommendation-healthPlans
    public function healthPlans (){
        return $this->hasMany(HealthPlan::class);
    }
    
}
