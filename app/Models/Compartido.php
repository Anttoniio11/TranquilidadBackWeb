<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compartido extends Model
{
    use HasFactory;

    protected $fillable = ['red_social'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function publicacion(){
        return $this->belongsTo(Publicacion::class);
    }
}
