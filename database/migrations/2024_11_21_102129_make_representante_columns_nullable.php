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
        Schema::table('lq_liquidaciones', function (Blueprint $table) {
            $table->string('representante_cliente_documento')->nullable()->change();
            $table->string('representante_cliente_nombre')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lq_liquidaciones', function (Blueprint $table) {
            $table->string('representante_cliente_documento')->nullable(false)->change();
            $table->string('representante_cliente_nombre')->nullable(false)->change();
        });
    }
};
