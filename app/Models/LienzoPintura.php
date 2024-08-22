<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienzoPintura extends Model
{
    use HasFactory;

    public function pintura(){
        return $this->belongsTo(Pintura::class);
    }

    public function herramienta_color(){
        return $this->belongsTo(HerramientaColor::class);
    }
}
