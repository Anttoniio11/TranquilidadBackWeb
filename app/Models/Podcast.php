<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory,ApiTrait;

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
        return $this->belongsToMany(Playlist::class, 'playlist_podcast');
    }
}
