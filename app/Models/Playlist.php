<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlists'; // Define el nombre de la tabla
    protected $guarded = []; // Permite la asignación masiva para todos los campos

    // Listas Blancas para incluir relaciones, filtrar y ordenar

    protected $allowIncluded = ['user', 'audios', 'podcasts']; // Relaciona con User, Audio, Podcast
    protected $allowFilter = ['id', 'name', 'description', 'user_id']; // Filtros posibles
    protected $allowSort = ['id', 'name', 'created_at']; // Campos de ordenamiento
    



    // Relación de uno a muchos
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
