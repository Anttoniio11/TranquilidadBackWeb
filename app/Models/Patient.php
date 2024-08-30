<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Patient extends Model
{
    use HasFactory;

    // Campos que se van a asignación masiva
    protected $fillable = [
        'nombre', 
        'apellido', 
        'edad', 
        'correo', 
        'telefono', 
        'departamento', 
        'municipio', 
        'direccion'
    ];

    // Relaciones permitidas para incluir
    protected $allowIncluded = ['resource', 'appointment', 'message', 'bill', 'review'];

    // Campos permitidos para filtrado
    protected $allowFilter = [
        'id', 'nombre', 'apellido', 'edad', 'correo', 'telefono', 'departamento', 'municipio', 'direccion'
    ];

    // Campos permitidos para ordenamiento
    protected $allowSort = [
        'id', 'nombre', 'apellido', 'edad', 'correo', 'telefono', 'departamento', 'municipio', 'direccion'
    ];



    // Relación muchos a muchos con Resource
    public function resource()
    {
        return $this->belongsToMany(Resource::class);
    }

    // Relación uno a muchos con Appointment
    public function appointment()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relación uno a muchos con Message
    public function message()
    {
        return $this->hasMany(Message::class);
    }

    // Relación uno a muchos con Bill
    public function bill()
    {
        return $this->hasMany(Bill::class);
    }

    // Relación uno a uno con Review
    public function review()
    {
        return $this->hasOne(Review::class);
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
                $query->where($filter, 'LIKE', '%' . $value . '%');
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
