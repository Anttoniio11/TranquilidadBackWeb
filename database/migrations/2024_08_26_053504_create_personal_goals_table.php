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
        Schema::create('personal_goals', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('target_value', 10, 2);
            $table->decimal('current_value', 10, 2)->nullable();
            $table->string('unit', 50);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['in progress', 'completed', 'abandoned'])->default('in progress');

            //foranea de result
            $table->foreignId('result_id')->constrained()->onDelete('cascade');

            //foranea de user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_goals');
    }
};
