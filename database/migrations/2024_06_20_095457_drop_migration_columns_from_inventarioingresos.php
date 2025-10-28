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
            $table->dropColumn('documento_proveedor');
            $table->dropColumn('proveedor');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->string('documento_proveedor');
            $table->string('proveedor');
        });
    }
};
