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
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->boolean('notificaciones')->default(true);
            $table->enum('privacidad',['privada','publico'])->default('privada');
            $table->enum('idioma',['español','ingles'])->default('español');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade'); // Foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracions');
    }
};
