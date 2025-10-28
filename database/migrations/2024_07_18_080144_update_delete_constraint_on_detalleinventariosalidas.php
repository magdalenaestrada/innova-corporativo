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
        Schema::table('detalleinventariosalidas', function (Blueprint $table) {
            // Drop existing foreign key constraint if any
            $table->dropForeign(['producto_id']);

            // Re-add foreign key with the new onDelete constraint
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalleinventariosalidas', function (Blueprint $table) {
            // Drop the updated foreign key constraint
            $table->dropForeign(['producto_id']);

            // Re-add the foreign key without the onDelete constraint
            $table->foreign('producto_id')->references('id')->on('productos');
        });

    }
};
