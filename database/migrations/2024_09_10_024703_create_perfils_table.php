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
        Schema::create('perfils', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('tipo_perfil')->default('normal'); // 'Normal' o 'Profesional'
            $table->string('foto_perfil')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('lugar_residencia');
            $table->string('lugar_nacimiento');
            $table->text('acerca_de_mi')->nullable();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade'); // Foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfils');
    }
};

