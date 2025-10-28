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
        Schema::table('inventarioprestamosalidadetalles', function (Blueprint $table) {
            $table->string('precio_salida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarioprestamosalidadetalles', function (Blueprint $table) {
            $table->dropColumn('precio_salida');

        });
    }
};
