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
        Schema::table('ingresoinventarioapertura', function (Blueprint $table) {
            $table->string('usuario_creador')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresoinventarioapertura', function (Blueprint $table) {
            $table->dropColumn('usuario_creador');
        });
    }
};
