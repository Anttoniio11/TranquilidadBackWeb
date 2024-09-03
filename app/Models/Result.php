<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    //recibe a user de 1 a muchos result-user
    public function user (){
        return $this->belongsTo(User::class);
    }

    //recibe a questionnaire de 1 a muchos result-questionnaire
    public function questionnaire (){
        return $this->belongsTo(Questionnaire::class);
    }

    //relacion a recommendations de 1 a muchos result-recommendations
    public function recommendations (){
        return $this->hasMany(Recommendation::class);
    }
}
