<?php

namespace App\Models\arteTerapia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanvasPainting extends Model
{
    use HasFactory;

      public function painting(){
        return $this->belongsTo(Painting::class);
    }

    public function toolColor(){
        return $this->belongsTo(ToolColor::class);
    } 
}
