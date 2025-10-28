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
        Schema::create('ranchos', function (Blueprint $table) {
            $table->id();
            $table->string('documento_cliente');
            $table->string('datos_cliente');
            $table->string('documento_socio')->nullable();
            $table->string('datos_socio')->nullable();
            $table->string('cantidad');
            $table->string('estado');
            $table->string('cancelado');
            $table->foreignId('comida_id')->constrained();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranchos');
    }
};
