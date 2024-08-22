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
        Schema::create('lienzo_dibujos', function (Blueprint $table) {
            $table->id();

            //FK
            $table->unsignedBigInteger('pincel_id');
            $table->foreign('pincel_id')
                ->references('id')
                ->on('pincels')
                ->onDelete('cascade');
            
            $table->unsignedBigInteger('forma_id');
            $table->foreign('forma_id')
                ->references('id')
                ->on('formas')
                ->onDelete('cascade');

            $table->unsignedBigInteger('herramienta_color_id');
            $table->foreign('herramienta_color_id')
                ->references('id')
                ->on('herramienta_colors')
                ->onDelete('cascade');

            $table->unsignedBigInteger('dibujo_id');
            $table->foreign('dibujo_id')
                ->references('id')
                ->on('dibujos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lienzo_dibujos');
    }
};
