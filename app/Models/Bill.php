<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    //Relacion uno a muchos con patient
    public function patient(){
        return $this->belongsTo('App\Models\patient');
    }

    //Relacion uno a muchos con bank
    public function bank(){
        return $this->belongsTo('App\Models\Bank');
    }

    //Relacion uno a uno con methodPayment
    public function methodPayment(){
        return $this->hasOne('App\Models\MethodPayment');
    }
}
