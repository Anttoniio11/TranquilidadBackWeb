<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con resource
    public function resource(){
        return $this->belongsToMany('App\Models\Resource');
    }

    //Relacion uno a muchos con appointment
    public function appointment(){
        return $this->hasMany('App\Models\Appointment');
    }

    //Relacion uno a muchos con message
    public function message(){
        return $this->hasMany('App\Models\Message');
    }

    //Relacion uno a muchos con bill
    public function bill(){
        return $this->hasMany('App\Models\Bill');
    }

    //Relacion uno a uno con review
    public function review(){
        return $this->hasOne('App\Models\Review');
    }
}
