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
        Schema::create('inv_salidasrapidas', function (Blueprint $table) {
            $table->id();
            $table->string('usuario_creador');
            $table->string('destino');
            $table->string('documento_solicitante');
            $table->string('nombre_solicitante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_salidasrapidas');
    }
};
