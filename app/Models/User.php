<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //relacion de uno a muchos con result
    public function results (){
        return $this->hasMany(Result::class);
    }

    //relacion de  uno a muchos con questionnaire
    public function questionaires (){
        return $this->hasMany(Questionnaire::class);
    }

    //relacion de uno a muchos con personal goal
    public function personalGoals (){
        return $this->hasMany(PersonalGoal::class,); 
    }

    //relacion de muchos a muchos con forum
    public function forums (){
        return $this->belongsToMany(Forum::class);    
    }
}
