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
        Schema::table('ts_cajas', function (Blueprint $table) {
            $table->dropForeign(['encargado_id']); // Drop the foreign key constraint
            $table->dropColumn('encargado_id'); // Drop the column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ts_cajas', function (Blueprint $table) {
            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->foreign('encargado_id')->references('id')->on('empleados')->onDelete('restrict');
        });
    }
};
