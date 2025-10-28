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
            $table->unsignedBigInteger('proveedor_id')->nullable();

            $table->foreign('proveedor_id')->references('id')->on('proveedors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']); // Dropping foreign key constraint
            $table->dropColumn('proveedor_id');


        });
    }
};
