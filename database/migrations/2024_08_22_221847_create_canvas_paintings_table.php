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
        Schema::create('canvas_paintings', function (Blueprint $table) {
            $table->id();
            /* //FK
            $table->unsignedBigInteger('herramienta_color_id');
            $table->foreign('herramienta_color_id')
                ->references('id')
                ->on('herramienta_colors')
                ->onDelete('cascade');

            $table->unsignedBigInteger('pintura_id');
            $table->foreign('pintura_id')
                ->references('id')
                ->on('pinturas')
                ->onDelete('cascade'); */
                        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvas_paintings');
    }
};
