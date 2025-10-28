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
        Schema::create('ts_depositos_cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ts_salida_cuenta_id');
            $table->unsignedBigInteger('ts_ingreso_cuenta_id');
            $table->decimal('tipo_cambio', 3,2)->nullable();
            $table->timestamps();

            $table->foreign('ts_salida_cuenta_id')->references('id')->on('ts_salidas_cuentas');
            $table->foreign('ts_ingreso_cuenta_id')->references('id')->on('ts_ingresos_cuentas');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ts_depositos_cuentas');
    }
};
