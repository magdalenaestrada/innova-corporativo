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
        Schema::create('lq_adelantos', function (Blueprint $table) {
            $table->id();
            
            $table->boolean('cerrado')->default(value: false);
            $table->longText('descripcion')->nullable();
            $table->decimal('tipo_cambio', 3,2)->nullable();
            $table->boolean('abierto');

            $table->string('representante_cliente_documento')->nullable();
            $table->string('representante_cliente_nombre')->nullable();
            $table->unsignedBigInteger('sociedad_id');
            $table->unsignedBigInteger('salida_cuenta_id');
            $table->unsignedBigInteger('creador_id');
            $table->timestamps();

            $table->foreign('sociedad_id')->references('id')->on('lq_sociedades')->onDelete('restrict');
            $table->foreign('salida_cuenta_id')->references('id')->on('ts_salidas_cuentas')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lq_adelantos');
    }
};
