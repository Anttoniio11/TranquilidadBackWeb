<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con patient
    public function patient(){
        return $this->belongsToMany(Patient::class);
    }

    //Relacion uno a muchos con professional
    public function professional(){
        return $this->belongsTo(Professional::class);
    }
}
