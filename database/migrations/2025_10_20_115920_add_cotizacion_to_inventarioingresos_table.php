<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            // VARCHAR “nada más” (sin constraints), lo dejo nullable para no romper registros antiguos
            $table->string('cotizacion', 255)->nullable()->after('tipomoneda');
        });
    }

    public function down(): void {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->dropColumn('cotizacion');
        });
    }
};