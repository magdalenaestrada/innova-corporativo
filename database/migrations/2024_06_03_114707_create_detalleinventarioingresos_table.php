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
        Schema::create('detalleinventarioingresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventarioingreso_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('precio')->nullable();
            $table->string('cantidad')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('estado')->nullable();
            $table->string('cantidad_ingresada')->default(0);
            $table->string('guiaingresoalmacen')->nullable();

            $table->timestamps();

            $table->foreign('inventarioingreso_id')->references('id')->on('inventarioingresos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleinventarioingresos');
    }
};
