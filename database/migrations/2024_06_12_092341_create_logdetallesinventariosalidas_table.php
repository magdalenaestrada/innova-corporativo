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
        Schema::create('logdetallesinvsalidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalleinventariosalida_id')->constrained();
            $table->string('usuario');
            $table->string('cantidad_entregada');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logdetallesinvsalidas');
    }
};
