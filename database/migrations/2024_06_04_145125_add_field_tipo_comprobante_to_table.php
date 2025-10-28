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
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->string('tipocomprobante')->nullable();
            $table->string('tipopago')->nullable();
            $table->string('estado_pago')->nullable();
            $table->string('documento_proveedor')->nullable();
            $table->string('proveedor')->nullable();
            $table->date('fecha_emision_comprobante')->nullable();
            $table->timestamp('fecha_pago_al_credito')->nullable();
            $table->string('usuario_pago_al_credito')->nullable();
            $table->string('tipomoneda')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('cambio_dolar_precio_venta')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->dropColumn('tipocomprobante');
            $table->dropColumn('tipopago');
            $table->dropColumn('estado_pago');
            $table->dropColumn('documento_proveedor');
            $table->dropColumn('proveedor');
            $table->dropColumn('fecha_emision_comprobante');
            $table->dropColumn('fecha_pago_al_credito');
            $table->dropColumn('usuario_pago_al_credito');
            $table->dropColumn('tipomoneda');
            $table->dropColumn('subtotal');
            $table->dropColumn('cambio_dolar_precio_venta');
        });
    }
};
