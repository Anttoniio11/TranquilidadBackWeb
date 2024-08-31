<?php

namespace App\Models;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory ,ApiTrait;

    protected $table = 'audios';
    protected $guarded = [];


    //Listas Blancas
    protected $allowIncluded = ['genre', 'album', 'playlists', 'tags', 'likes', 'histories'];
    protected $allowFilter = ['id', 'title', 'duration'];
    protected $allowSort = ['id', 'title'];




    // Relación Uno a Muchos Inversa
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relación  Uno a Muchos Inversa
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Relación  Uno a Muchos Inversa
    public function binauralSound()
    {
        return $this->belongsTo(BinauralSound::class);
    }

    // Relación Muchos a Muchos polimórfica con el modelo Tag
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }




    // Relación Uno a Muchos polimórfica inversa con el modelo Like
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // Relación Uno a Muchos polimórfica con el modelo History
    public function histories()
    {
        return $this->morphMany(History::class, 'historable');
    }


    //Muchos a Muchos
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'audio_playlist');
    }
}
