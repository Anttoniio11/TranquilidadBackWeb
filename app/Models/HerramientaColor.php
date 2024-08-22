<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HerramientaColor extends Model
{
    use HasFactory;

    public function lienzo_pinturas(){
        return $this->hasMany(LienzoPintura::class);
    }

    public function lienzo_dibujos(){
        return $this->hasMany(LienzoDibujo::class);
    }
}
