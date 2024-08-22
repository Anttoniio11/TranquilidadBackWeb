<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincel extends Model
{
    use HasFactory;

    public function lienzo_dibujos(){
        return $this->hasMany(LienzoDibujo::class);
    }
}
