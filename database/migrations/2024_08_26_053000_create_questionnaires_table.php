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
        Schema::create('questionnaires', function (Blueprint $table) {
            $table->id();
            $table->enum('genero', ['masculino', 'femenino']);
            $table->float('peso');
            $table->float('altura');
            $table->integer('edad');
            $table->enum('nivel_actividad', ['sedentario', 'ligero', 'moderado', 'activo', 'muy activo']);
            $table->enum('tipo_trabajo', ['sedentario', 'activo']);
            $table->integer('horas_dormidas');
            $table->enum('nivel_estres', ['bajo', 'moderado', 'alto']);
            $table->enum('frecuencia_comida_procesada', ['baja', 'moderada', 'alta']);
            $table->integer('frecuencia_comidas');
            $table->enum('consumo_alcohol', ['ocasional', 'regular', 'no consume']);    
            //$table->string('condicion_medica')->nullable();
            $table->enum('objetivo', ['mantener peso', 'perder peso', 'ganar peso']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
    }
};
