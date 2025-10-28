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
        Schema::create('ts_salidas_cuentas', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 15, 2);
            $table->string('comprobante_correlativo')->nullable();
            $table->longText('descripcion')->nullable();
            $table->unsignedBigInteger('cuenta_id');
            $table->unsignedBigInteger('motivo_id');
            $table->unsignedBigInteger('beneficiario_id')->nullable();
            $table->unsignedBigInteger('tipo_comprobante_id')->nullable();
            $table->unsignedBigInteger('creador_id');

            $table->foreign('cuenta_id')->references('id')->on('ts_cuentas')->onDelete('restrict');
            $table->foreign('motivo_id')->references('id')->on('ts_motivos')->onDelete('restrict');
            $table->foreign('beneficiario_id')->references('id')->on('ts_beneficiarios')->onDelete('restrict');
            $table->foreign('tipo_comprobante_id')->references('id')->on('tipo_comprobante')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ts_salidas_cuentas');
    }
};
