<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    //Relacion muchos a muchos con professional
    public function professional(){
        return $this->belongsToMany(Professional::class);
    }
}
