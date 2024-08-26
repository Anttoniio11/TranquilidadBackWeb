<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dibujo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_dibujo','contenido_dibujo'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function carpeta(){
        return $this->belongsTo(Carpeta::class);
    }

    public function lienzo_dibujos(){
        return $this->hasMany(LienzoDibujo::class);
    }
}

