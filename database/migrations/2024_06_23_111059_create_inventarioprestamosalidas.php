<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventarioprestamosalidas', function (Blueprint $table) {
            $table->id();
            $table->string('destino');
            $table->string('condicion');
            $table->string('documento_responsable');
            $table->string('nombre_responsable');
            $table->string('usuario_creador');
            $table->string('usuario_devol_confirm')->nullable();
            $table->string('observacion');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarioprestamosalidas');
    }
};
