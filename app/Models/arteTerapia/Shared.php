<?php

namespace App\Models\arteTerapia;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shared extends Model
{
    use HasFactory;

    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function publication(){
        return $this->belongsTo(Publication::class);
    } 
}
