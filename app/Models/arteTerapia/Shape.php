<?php

namespace App\Models\arteTerapia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shape extends Model
{
    use HasFactory;

    public function canvasDrawings(){
        return $this->hasMany(CanvasDrawing::class);
    } 
}
