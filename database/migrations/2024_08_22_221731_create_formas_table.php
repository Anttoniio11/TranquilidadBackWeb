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
        Schema::create('formas', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_forma');
            $table->float('x');
            $table->float('y');
            $table->float('ancho');
            $table->float('alto');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formas');
    }
};
