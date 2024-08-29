<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CategoryResourse;

class Bank extends Model
{
    use HasFactory;

    //Relacion uno a muchos con bill
    public function bill(){
        return $this->hasMany(Bill::class);
    }
}
