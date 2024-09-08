<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shared extends Model
{
    use HasFactory;

<<<<<<< HEAD:app/Models/Compartido.php
    protected $fillable = ['user_id', 'publicacion_id','red_social'];
    protected $allowIncluded =['user','publicacion'];
=======
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Models/Shared.php
    
    public function user(){
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD:app/Models/Compartido.php
    public function publicacion(){
        return $this->belongsTo(Publicacion::class);
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
        $query->wit($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

        //http://api.codersfree1.test/v1/categories?included=posts


=======
    public function publication(){
        return $this->belongsTo(Publication::class);
>>>>>>> e7ee0d8c861799810f9495ad33caab6cc1867397:app/Models/Shared.php
    } 
}
