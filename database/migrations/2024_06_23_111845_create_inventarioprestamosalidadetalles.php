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
        Schema::create('inventarioprestamosalidadetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventarioprsalida_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('cantidad');
            $table->string('usuario_devol_confirm')->nullable();
            $table->timestamps();



            $table->foreign('inventarioprsalida_id')->references('id')->on('inventarioprestamosalidas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarioprestamosalidadetalles');
    }
};
