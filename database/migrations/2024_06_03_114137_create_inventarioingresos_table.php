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
        Schema::create('inventarioingresos', function (Blueprint $table) {
            $table->id();

            $table->string('total')->nullable();
            $table->string('usuario_cancelacion')->nullable();
            $table->string('usuario_recepcionista')->nullable();
            $table->string('usuario_ordencompra')->nullable();
            $table->dateTime('fecha_cancelacion')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('comprobante_correlativo')->nullable();
            $table->string('estado')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarioingresos');
    }
};
