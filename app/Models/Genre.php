<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Genre extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $allowIncluded= ['audios'];
    protected $allowFilter= ['id','name','description'];
    protected $allowSort= ['id','name'];


    // Relación de uno a muchos con el modelo Audio
    public function audios()
    {
        return $this->hasMany(Audio::class);
    }



    public function scopeIncluded(Builder $query ){

        if(empty($this->allowIncluded)||empty(request('included'))){

            return;

        }

        $relations = explode(',',request('included')); //busqueda cliente=[audios,relacion2]

        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $value) {
            if(! $allowIncluded->contains($value)){
                unset($relations[$key]);
            }
        }

        $query->with($relations);

    }


    public function scopeFilter( Builder $query){

        if(empty($this->allowFilter) || empty(request('filter'))){

            return;

        }

        $filters = request('filter');
        
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if($allowFilter->contains($filter)){
                $query->where($filter, 'LIKE', '%'.$value.'%');
            }
        }
        //http://tranquilidad.test/v1/genres?filter[name]=ambiental

    }
    public function scopeSort( Builder $query){

        if(empty($this->allowSort) || empty(request('sort'))){
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {

            $direction = 'asd';
            if(substr($sortField,0,1) == '-'){
                $direction = 'desc';
                $sortField = substr($sortField,1);


            }

            if($allowSort->contains($sortField)){
                $query->orderBy($sortField,$direction);

            }
        }
        //http://tranquilidad.test/v1/genres?sort=name
        
    }

    public function scopeGetOrPaginate(Builder $query){

        if(request('perPage')){
            $perPage= intval(request('perPage')); //cadena a numero
            
            if($perPage){
                return $query->paginate($perPage);

            }

        }
        return $query->get();
    }

    //http://tranquilidad.test/v1/genres?perPage=2 

}
