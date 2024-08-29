<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CategoryResourse;

class Bill extends Model
{
    use HasFactory;

    //Relacion uno a muchos con patient
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    //Relacion uno a muchos con bank
    public function bank(){
        return $this->belongsTo(Bank::class);
    }

    //Relacion uno a uno con methodPayment
    public function methodPayment(){
        return $this->hasOne(MethodPayment::class);
    }
}
