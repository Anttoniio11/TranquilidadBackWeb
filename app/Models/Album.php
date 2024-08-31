<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory,ApiTrait ;

    protected $guarded = [];

    //Listas Blancas
    protected $allowIncluded= ['audios'];
    protected $allowFilter= ['id','title','description'];
    protected $allowSort= ['id','title'];


    // Relación de uno a muchos con el modelo Audio
    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
