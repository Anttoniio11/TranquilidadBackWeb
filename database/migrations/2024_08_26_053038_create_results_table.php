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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->text('resultados');
            $table->string('genero');
            $table->float('peso');
            $table->float('altura');
            $table->integer('edad');
            $table->string('nivel_actividad');
            $table->string('tipo_trabajo');
            $table->integer('horas_dormidas');
            $table->string('nivel_estres');
            $table->string('frecuencia_comida_procesada');
            $table->integer('frecuencia_comidas');
            $table->string('consumo_alcohol');    
          //  $table->string('condicion_medica')->nullable();
            $table->string('objetivo');

            //foreign of questionnaire
            $table->unsignedBigInteger('questionnaire_id');
            $table->foreign('questionnaire_id')->references('id')->on('questionnaires')->onDelete('cascade');

            //foreign of user or central table of user and food
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
