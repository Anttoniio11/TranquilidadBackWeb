<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CategoryResourse;

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
