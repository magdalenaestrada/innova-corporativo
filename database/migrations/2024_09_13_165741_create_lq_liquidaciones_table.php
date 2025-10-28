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
        Schema::create('lq_liquidaciones', function (Blueprint $table) {
            $table->id();
            $table->string('representante_cliente_documento');
            $table->string('representante_cliente_nombre');
            $table->decimal('tipo_cambio', 3,2)->nullable();
            $table->decimal('descuento', 15,2)->nullable();
            $table->unsignedBigInteger('sociedad_id');
            $table->unsignedBigInteger('salida_cuenta_id');
            $table->unsignedBigInteger('creador_id');
            $table->foreign('sociedad_id')->references('id')->on('lq_sociedades')->onDelete('restrict');
            $table->foreign('salida_cuenta_id')->references('id')->on('ts_salidas_cuentas')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lq_liquidaciones');
    }
};
