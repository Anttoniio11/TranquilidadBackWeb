<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    use HasFactory;

    protected $table='estudios';

    protected $fillable = [
        'titulo',
        'institucion',
        'año_finalización',
        'id_perfil',
    ];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil');
    }
}
