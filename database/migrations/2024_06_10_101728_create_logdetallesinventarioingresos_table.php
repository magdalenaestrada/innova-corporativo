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
        Schema::create('logdetallesinvingresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalleinventarioingreso_id')->constrained();
            $table->string('usuario');
            $table->string('cantidad_ingresada');
            $table->string('guiaingresoalmacen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logdetallesinvingresos');
    }
};
