<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Bill extends Model
{
    use HasFactory;

    // Campos que se van a asignación masiva
    protected $fillable = [
        'nombre',
        'descripcion',
        'patient_id'
    ];

    // Relaciones permitidas para incluir
    protected $allowIncluded = ['patient', 'bank', 'methodPayment'];

    // Campos permitidos para filtrado
    protected $allowFilter = ['id', 'nombre', 'descripcion', 'patient_id'];

    // Campos permitidos para ordenamiento
    protected $allowSort = ['id', 'nombre', 'descripcion', 'created_at'];



    // Relación uno a muchos con Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relación uno a muchos con Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // Relación uno a uno con MethodPayment
    public function methodPayment()
    {
        return $this->hasOne(MethodPayment::class);
    }



    // Scope para incluir relaciones
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

    // Scope para filtrar resultados
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%'); //nos retorna todos los registros que conincidad, asi sea en una porcion del texto
            }
        }
    }

    // Scope para ordenar resultados
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

    // Scope para obtener o paginar resultados
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
}
