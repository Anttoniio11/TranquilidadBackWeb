<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    //relacion 1 a muchos forum-processLogs
    public function processLogs (){
        return $this->hasMany(ProcessLog::class);
    }
    
}
