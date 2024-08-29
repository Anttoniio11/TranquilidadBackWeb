<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    use HasFactory;

    //Relacion uno a uno con bill
    public function bill(){
        return $this->belongsTo('App\Models\Bill');
    }
}
