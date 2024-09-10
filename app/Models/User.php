<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\arteTerapia\Drawing;
use App\Models\arteTerapia\Gallery;
use App\Models\arteTerapia\Painting;
use App\Models\arteTerapia\Publication;
use App\Models\arteTerapia\Reaction;
use App\Models\arteTerapia\Shared;
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

    public function publications(){
        return $this->hasMany(Publication::class);
    }

    public function shareds(){
        return $this->hasMany(Shared::class);
    }

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function paintings(){
        return $this->hasMany(Painting::class);
    }

    public function drawings(){
        return $this->hasMany(Drawing::class);
    }
}
