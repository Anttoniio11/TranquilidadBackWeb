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
        Schema::create('user_forum', function (Blueprint $table) {
            $table->id();
            //foranea de user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //foranea de forum
            $table->foreignId('forum_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_forum');
    }
};
