<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LienzoPintura extends Model
{
    use HasFactory;

    protected $fillable = ['herramienta_color_id','pintura_id'];

    public function pintura(){
        return $this->belongsTo(Pintura::class);
    }

    public function herramienta_color(){
        return $this->belongsTo(HerramientaColor::class);
    }
}
