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
            $table->decimal('suma', 10, 3)->nullable();
            $table->decimal('descuento', 10, 3)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventarioingresos', function (Blueprint $table) {
            $table->dropColumn('suma');
            $table->dropColumn('descuento');
        });
    }
};
