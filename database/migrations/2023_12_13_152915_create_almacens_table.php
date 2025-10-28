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
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_almacen');
            $table->string('nombre_almacen');
            $table->string('horario_almacen');
            $table->unsignedBigInteger('responsable_id');
            $table->string('contacto_almacen');
            $table->text('ubicacion_almacen');
            $table->text('descripcion_almacen')->nullable();
            $table->timestamps();

            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('almacens');
    }
};
