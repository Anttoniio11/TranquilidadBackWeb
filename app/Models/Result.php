<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    //campos que se van para asignasion masiva
    protected $fillable = [
        'resultados',
        'genero',
        'peso',
        'altura',
        'edad',
        'nivel_actividad',
        'tipo_trabajo',
        'horas_dormidas',
        'nivel_estres',
        'frecuencia_comida_procesada',
        'frecuencia_comidas',
        'consumo_alcohol',
        'objetivo',
        'questionnaire_id',
        'user_id'
    ];

    //posibles querys 
    protected $allowIncluded = ['questionnaire','user','recommendations'];

    //por que columna queremos filtrar
    protected $allowFilter = ['id','genero','resultados'];

    //columnas por cual lo vamos a ordenar
    protected $allowSort  = [ 'id','created_at','updated_at'];

    //scope para relaciones anidadas 
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }

    //scope para filtar
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }

    //scope para ordenar
    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    //scope para paginar
    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage'));

            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }

    //recibe relacion uno a muchos de user
    public function user (){
        return $this->belongsTo(User::class,'user_id');
    }

    //recibe relacion uno a muchos de questionnaire
    public function questionnaire (){
        return $this->belongsTo(Questionnaire::class,'questionnaire_id');
    }

    //recibe relacion de uno a muchos de personal goal
    public function personagoal (){
        return $this->belongsTo(PersonalGoal::class);
    }

    
}
