<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //muchos a muchos 

    public function audios()
    {
        return $this->belongsToMany(Audio::class, 'audio_playlist');
    }

    public function podcasts()
    {
        return $this->belongsToMany(Podcast::class, 'playlist_podcast');
    }
}
