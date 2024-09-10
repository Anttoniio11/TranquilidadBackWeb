<?php

namespace App\Models\arteTerapia;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable=['user_id','publicacion_id','tipo_reaccion'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function publication(){
        return $this->belongsTo(Publication::class);
    } 
}
