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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();

            $table->foreignId('accion_id')->constrained();
            $table->foreignId('motivo_id')->constrained();
            $table->foreignId('tipo_vehiculo_id')->constrained('tipos_vehiculos');
            $table->foreignId('estado_id')->constrained();

            $table->string('placa');
            $table->string('documento_cliente');
            $table->string('datos_cliente');
            $table->string('documento_conductor');
            $table->string('datos_conductor');
            $table->string('documento_balanza')->nullable();
            $table->string('datos_balanza')->nullable();
            $table->string('guia_remision')->nullable();
            $table->string('guia_transportista')->nullable();
            $table->string('observacion')->nullable();
            $table->string('toneladas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
