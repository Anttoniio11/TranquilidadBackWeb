<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function compartidos(){
        return $this->hasMany(Compartido::class);
    }

    public function reaccions(){
        return $this->hasMany(Reaccion::class);
    }
}
