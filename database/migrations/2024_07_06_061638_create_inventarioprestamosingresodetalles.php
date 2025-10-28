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
        Schema::create('inv_prestamosingresodetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventariopringreso_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('cantidad');
            $table->string('usuario_devol_confirm')->nullable();
            $table->string('precio_ingreso')->nullable();
            $table->timestamps();



            $table->foreign('inventariopringreso_id')->references('id')->on('inventarioprestamoingresos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_prestamosingresodetalles');
    }
};
