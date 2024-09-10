<?php

namespace App\Models\arteTerapia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanvasDrawing extends Model
{
    use HasFactory;

     public function brush(){
        return $this->belongsTo(Brush::class);
    }   
    
    public function shape(){
        return $this->belongsTo(Shape::class);
    }

    public function toolColor(){
        return $this->belongsTo(ToolColor::class);
    }

    public function drawing(){
        return $this->belongsTo(Drawing::class);
    } 
}
