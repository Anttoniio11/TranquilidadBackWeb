<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relación polimórfica inversa
    public function taggable()
    {
        return $this->morphTo();
    }
}
