<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pintura extends Model
{
    use HasFactory;

    protected $fillable=['user_id','nombre_pintura','contenido_dibujo','carpeta_id','plantilla_id'];
    protected $allowIncluded =['user','carpeta'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plantilla(){
        return $this->belongsTo(Plantilla::class);
    }

    public function carpeta(){
        return $this->belongsTo(Carpeta::class);
    }

    public function lienzo_pinturas(){
        return $this->hasMany(LienzoPintura::class);
    }

    public function scopeIncluded(Builder $query)
    {

        if(empty($this->allowIncluded)||empty(request('included'))){// validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            return;
        }

        
        $relations = explode(',', request('included')); //['posts','relation2']//recuperamos el valor de la variable included y separa sus valores por una coma

       // return $relations;

        $allowIncluded = collect($this->allowIncluded); //colocamos en una colecion lo que tiene $allowIncluded en este caso = ['posts','posts.user']

        foreach ($relations as $key => $relationship) { //recorremos el array de relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

        //http://api.codersfree1.test/v1/categories?included=posts
    }  
}
