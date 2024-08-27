<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Relación con el modelo Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relación con el modelo Album
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Relación con el modelo BinauralSound
    public function binauralSound()
    {
        return $this->belongsTo(BinauralSound::class);
    }

    // Relación polimórfica con el modelo Tag
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // Relación polimórfica con el modelo Like
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // Relación polimórfica con el modelo History
    public function histories()
    {
        return $this->morphMany(History::class, 'historable');
    }


    //muchos a muchos
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'audio_playlist');
    }
}
