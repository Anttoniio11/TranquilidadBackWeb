<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienzoDibujo extends Model
{
    use HasFactory;

    public function pincel(){
        return $this->belongsTo(Pincel::class);
    }   
    
    public function forma(){
        return $this->belongsTo(Forma::class);
    }

    public function herramienta_color(){
        return $this->belongsTo(HerramientaColor::class);
    }

    public function dibujo(){
        return $this->belongsTo(Dibujo::class);
    }
}
