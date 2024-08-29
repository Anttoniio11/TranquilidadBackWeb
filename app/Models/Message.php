<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\CategoryResourse;

class Message extends Model
{
    use HasFactory;

    //Relacion uno a muchos con patient
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    //Relacion uno a muchos con chat
    public function chat(){
        return $this->belongsTo(Chat::class);
    }
}
