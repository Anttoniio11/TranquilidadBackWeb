<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessLog extends Model
{
    use HasFactory;

    //recibe relacion uno a muchos processLogs-forum
    public function forum (){
        return $this->belongsTo(Forum::class);
    }

    //manda relacion uno a muchos
    public function personalgoals (){
        return $this->belongsTo(PersonalGoal::class);
    }
}
