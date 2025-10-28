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
        Schema::create('lq_devoluciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('sociedad_id');
            $table->unsignedBigInteger('ingreso_cuenta_id');
            $table->unsignedBigInteger('creador_id');
            $table->unsignedBigInteger('cliente_id')->nullable();

            $table->foreign('sociedad_id')->references('id')->on('lq_sociedades')->onDelete('restrict');
            $table->foreign('ingreso_cuenta_id')->references('id')->on('ts_ingresos_cuentas')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('cliente_id')->references('id')->on('lq_clientes')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lq_devoluciones');
    }
};
