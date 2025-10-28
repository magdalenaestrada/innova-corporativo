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
        Schema::create('abonado_rancho', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abonado_id');
            $table->unsignedBigInteger('rancho_id');
            $table->timestamps();

            
            // Define foreign keys
            $table->foreign('abonado_id')->references('id')->on('abonados')->onDelete('cascade');
            $table->foreign('rancho_id')->references('id')->on('ranchos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonado_rancho');
    }
};
