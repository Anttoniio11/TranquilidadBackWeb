<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail_path')->nullable(); //Ruta o URL de la miniatura representativa del episodio del podcast.
            $table->string('video_path')->unique(); //Ruta o URL del archivo de video del podcast, si es un podcast en video.    
            $table->integer('duration')->comment('Duration in seconds');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('podcasts');
    }
};
