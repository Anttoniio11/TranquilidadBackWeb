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
        Schema::create('health_plans', function (Blueprint $table) {
            $table->id();
            $table->integer('pesoKg');
            $table->integer('pesoDeseadoKg');
            $table->string('comidaHabitual');
            $table->string('alturaCm');
            $table->string('tipoMetabolismo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_plans');
    }
};
