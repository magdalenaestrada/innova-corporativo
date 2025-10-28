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
        Schema::table('ts_salidas_cajas', function (Blueprint $table) {
            $table->date('fecha')->nullable();
            $table->date('fecha_comprobante')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ts_salidas_cajas', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('fecha_comprobante');
        });
    }
};
