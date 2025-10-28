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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('documento');
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('sueldo')->nullable();
            $table->boolean('en_actividad')->nullable();
            $table->unsignedBigInteger('jefe_id')->nullable(); 
            $table->unsignedBigInteger('area_id')->nullable(); 
            $table->unsignedBigInteger('posicion_id')->nullable(); 
            $table->unsignedBigInteger('creador_id'); 
            $table->timestamps();


            $table->foreign('jefe_id')->references('id')->on('empleados')->onDelete('restrict');
            $table->foreign('posicion_id')->references('id')->on('posiciones')->onDelete('restrict');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
