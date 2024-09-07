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
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->integer('edad');
            $table->float('peso');
            $table->float('altura');
            $table->enum('actividad_fisica', ['sedentario', 'ligero', 'moderado', 'activo', 'muy_activo']);
            $table->enum('objetivo', ['mantener_peso', 'perder_peso', 'ganar_peso']);
            $table->enum('trabajo', ['oficina', 'moderado', 'fisico']);
            $table->enum('sueño', ['menos_5h', '5_6h', '7_8h', 'mas_8h']);
            $table->enum('estres', ['bajo', 'moderado', 'alto', 'muy_alto']);
            $table->enum('comida_rapida', ['diario', 'varias_veces_semana', 'una_vez_semana', 'rara_vez']);
            $table->enum('frecuencia_comidas', ['1_2_veces', '3_4_veces', '5_6_veces', 'mas_6_veces']);
            $table->enum('alcohol', ['diario', 'varias_veces_semana', 'una_vez_semana', 'rara_vez']);
            $table->string('condicion_medica')->nullable();
            $table->enum('frutas_verduras', ['todos_dias', '4_6_veces_semana', '2_3_veces_semana', '1_vez_menos']);
            $table->enum('energia', ['muy_alto', 'alto', 'moderado', 'bajo']);
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
