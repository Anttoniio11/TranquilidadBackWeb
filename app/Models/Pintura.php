<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pintura extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plantilla(){
        return $this->belongsTo(Plantilla::class);
    }

    public function carpeta(){
        return $this->belongsTo(Carpeta::class);
    }

    public function lienzo_pinturas(){
        return $this->hasMany(LienzoPintura::class);
    }
}
