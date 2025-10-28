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
        Schema::create('inv_ingresosrapidos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_comprobante');
            $table->string('comprobante_correlativo');
            $table->string('total');
            $table->string('usuario_creador');
            $table->unsignedBigInteger('proveedor_id')->nullable();

            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_ingresosrapidos');
    }
};
