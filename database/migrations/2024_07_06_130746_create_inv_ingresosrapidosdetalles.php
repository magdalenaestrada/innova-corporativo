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
        Schema::create('inv_ingresosrapidosdetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inv_ingresosrapidos_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('cantidad');
            $table->string('cantidad_recepcionada');
            $table->string('precio');
            $table->string('subtotal');
            $table->string('usuario_recepcion')->nullable();



            $table->foreign('inv_ingresosrapidos_id')->references('id')->on('inv_ingresosrapidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_ingresosrapidosdetalles');
    }
};
