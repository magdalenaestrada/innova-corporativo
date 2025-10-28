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
            $table->unsignedBigInteger('beneficiario_id')->nullable();
           
            $table->foreign('beneficiario_id')->references('id')->on('ts_beneficiarios')->onDelete('restrict');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ts_salidas_cajas', function (Blueprint $table) {
            $table->dropForeign(['beneficiario_id']);
            $table->dropColumn('beneficiario_id');
        });
    }
};
