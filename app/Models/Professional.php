<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con profession
    public function profession(){
        return $this->belongsToMany('App\Models\Profession');
    }

    //Relacion uno a muchos con appointment
    public function appointment(){
        return $this->hasMany('App\Models\Appointment');
    }

    //Relacion uno a muchos con resource
    public function resource(){
        return $this->hasMany('App\Models\Resource');
    }
}
