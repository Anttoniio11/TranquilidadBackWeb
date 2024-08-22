<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function pinturas(){
        return $this->hasMany(Pintura::class);
    }

    public function dibujos(){
        return $this->hasMany(Dibujo::class);
    }
}
