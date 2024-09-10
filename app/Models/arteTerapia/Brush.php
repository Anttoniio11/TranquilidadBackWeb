<?php

namespace App\Models\arteTerapia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brush extends Model

{

    use HasFactory;
    
    protected $fillable = ['tipo_forma','x','y','ancho','alto'];

    public function canvasDrawings(){
        return $this->hasMany(CanvasDrawing::class);
    }
}
