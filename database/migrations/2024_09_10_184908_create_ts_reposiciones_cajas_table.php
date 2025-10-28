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
        Schema::create('ts_reposiciones_cajas', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 15, 2);
            $table->string('comprobante_correlativo')->nullable(); 
            $table->boolean('confirmacion')->default(false); 
            $table->longText('descripcion')->nullable();
            $table->decimal('ultimo_balance_caja', 15, 2);
            $table->unsignedBigInteger('caja_id');
            $table->unsignedBigInteger('cuenta_procedencia_id');
            $table->unsignedBigInteger('salida_cuenta_id');
            $table->unsignedBigInteger('motivo_id');
            $table->unsignedBigInteger('tipo_comprobante_id')->nullable();
            $table->unsignedBigInteger('creador_id')->nullable();

            $table->timestamps();


            $table->foreign('caja_id')->references('id')->on('ts_cajas')->onDelete('restrict');
            $table->foreign('cuenta_procedencia_id')->references('id')->on('ts_cuentas')->onDelete('restrict');
            $table->foreign('salida_cuenta_id')->references('id')->on('ts_salidas_cuentas')->onDelete('restrict');

            $table->foreign('motivo_id')->references('id')->on('ts_motivos')->onDelete('restrict');
            $table->foreign('tipo_comprobante_id')->references('id')->on('tipo_comprobante')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ts_reposiciones_cajas');
    }
};
