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
        Schema::create('ts_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->nullable();
            $table->decimal('balance', 15, 2)->default(0)->check('balance >= 0');


            $table->unsignedBigInteger('tipo_moneda_id');
            $table->unsignedBigInteger('banco_id')->nullable();
            $table->unsignedBigInteger('encargado_id')->nullable();
            $table->unsignedBigInteger('creador_id')->nullable();
            $table->timestamps();

            $table->foreign('tipo_moneda_id')->references('id')->on('tipo_moneda')->onDelete('restrict');
            $table->foreign('banco_id')->references('id')->on('ts_bancos')->onDelete('restrict');
            $table->foreign('encargado_id')->references('id')->on('empleados')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ts_cuentas');
        Schema::enableForeignKeyConstraints();
    }
};
