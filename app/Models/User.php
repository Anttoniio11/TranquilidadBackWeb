<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'password',
        'fecha_creación',
        'activo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

   protected $allowIncluded = ['perfil','perfil.estudios','configuracion']; //las posibles Querys que se pueden realizar

    public function scopeIncluded(Builder $query)
    {

        if(empty($this->allowIncluded)||empty(request('included'))){// validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            // return;
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

    //relacion 1 a 1 con perfil
    public function perfil()
    {
        return $this->hasOne(Perfil::class, 'id_usuario');
    }

    public function configuracion()
    {
        return $this->hasOne(Configuracion::class, 'id_usuario');
    }

    //  Evento Eloquent para crear automáticamente un perfil cuando se crea un usuario
    // protected static function booted()
    // {
    //     static::created(function ($user) {
    //         // Cuando se crea un usuario, se crea un perfil automáticamente
    //         $user->perfil()->create([
    //             'tipo_perfil' => 'normal','profesional', // Ajusta según tu lógica
    //             'foto_perfil' => '', // Inicialmente vacío
    //             'fecha_nacimiento' =>'2002-09-03', // Dejar en null inicialmente
    //             'lugar_residencia' => 'popayan',
    //             'lugar_nacimiento' => 'popayan',
    //             'acerca_de_mi' => 'jejej',
    //         ]);
    //     });
    // }
}



