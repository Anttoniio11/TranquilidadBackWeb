<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $guarded = [];


    // Relación de uno a muchos con el modelo Audio
    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
