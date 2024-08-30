<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinauralSound extends Model
{
    use HasFactory, ApiTrait;

    protected $guarded =[];

    // Relación de uno a muchos con el modelo Audio
    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
