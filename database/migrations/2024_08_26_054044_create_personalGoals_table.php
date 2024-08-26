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
        Schema::create('personalGoals', function (Blueprint $table) {
            $table->id();

            //foreign of registration
            $table->unsignedBigInteger('processLog_id');
            $table->foreign('processLog_id')->references('id')->on('processLogs')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personalGoals');
    }
};
