<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    //Relacion uno a muchos con bill
    public function bill(){
        return $this->hasMany('App\Models\Bill');
    }
}
