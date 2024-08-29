<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    //Relacion uno a uno con patient
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    //Relacion uno a uno con professional
    public function professional(){
        return $this->belongsTo(Professional::class);
    }
}
