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
        Schema::create('inventariopagosacuenta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventarioingreso_id');
            $table->string('fecha_pago')->nullable();
            $table->string('monto')->nullable();
            $table->string('comprobante_correlativo')->nullable();
            $table->string('usuario');
            $table->timestamps();
            $table->foreign('inventarioingreso_id')->references('id')->on('inventarioingresos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventariopagosacuenta');
    }
};
