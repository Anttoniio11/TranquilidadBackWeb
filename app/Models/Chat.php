<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    //Relacion uno a muchos con message
    public function message(){
        return $this->hasMany(Message::class);
    }
}
