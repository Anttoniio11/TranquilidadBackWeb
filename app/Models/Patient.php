<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CategoryResourse;

class Patient extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con resource
    public function resource(){
        return $this->belongsToMany(Resource::class);
    }

    //Relacion uno a muchos con appointment
    public function appointment(){
        return $this->hasMany(Appointment::class);
    }

    //Relacion uno a muchos con message
    public function message(){
        return $this->hasMany(Message::class);
    }

    //Relacion uno a muchos con bill
    public function bill(){
        return $this->hasMany(Bill::class);
    }

    //Relacion uno a uno con review
    public function review(){
        return $this->hasOne(Review::class);
    }
}
