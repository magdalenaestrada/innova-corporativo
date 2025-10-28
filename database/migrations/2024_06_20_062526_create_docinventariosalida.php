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
        Schema::create('docinventariosalidas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('area_solicitante');
            $table->string('documento_solicitante');
            $table->string('nombre_solicitante');
            $table->string('prioridad');


            $table->unsignedBigInteger('inventariosalida_id');
            $table->timestamps();
            $table->foreign('inventariosalida_id')->references('id')->on('inventariosalidas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docinventariosalidas');
    }
};
