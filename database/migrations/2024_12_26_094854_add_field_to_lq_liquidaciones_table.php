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
            $table->decimal('total_sin_detraccion', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lq_liquidaciones', function (Blueprint $table) {
            $table->dropColumn('total_sin_detraccion');
        });
    }
};
