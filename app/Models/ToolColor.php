<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolColor extends Model
{
    use HasFactory;

   public function canvasPaintings(){
        return $this->hasMany(CanvasPainting::class);
    }

    public function canvasDrawings(){
        return $this->hasMany(CanvasDrawing::class);
    } 
}
