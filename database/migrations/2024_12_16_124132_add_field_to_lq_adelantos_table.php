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
        Schema::table('lq_adelantos', function (Blueprint $table) {
            $table->boolean('devuelto')->default(false); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lq_adelantos', function (Blueprint $table) {
            $table->dropColumn('devuelto');
        });
    }
};
