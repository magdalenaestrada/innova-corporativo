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
        Schema::create('programacion_registro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programacion_id');
            $table->unsignedBigInteger('registro_id');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('programacion_id')->references('id')->on('programacions')->onDelete('cascade');
            $table->foreign('registro_id')->references('id')->on('registros')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programacion_registro');
    }
};



