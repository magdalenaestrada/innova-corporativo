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
            $table->date('fecha')->nullable();
            $table->decimal('otros_descuentos', 10, 2)->nullable();
            $table->decimal('total', 15, 2);

 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lq_liquidaciones', function (Blueprint $table) {
            $table->dropColumn('fecha');
            $table->dropColumn('otros_descuentos');
            $table->dropColumn('total');
        });
    }
};
