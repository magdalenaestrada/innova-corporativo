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
        Schema::create('detalleinventariosalidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventariosalida_id');
            $table->unsignedBigInteger('producto_id');

            $table->string('cantidad')->nullable();
            $table->string('cantidad_entregada')->default(0);

            $table->timestamps();

            $table->foreign('inventariosalida_id')->references('id')->on('inventariosalidas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleinventariosalidas');
    }
};
