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
        Schema::create('garitas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc_empresa', 11);
            $table->string('nombre_garita')->unique();
            $table->string('ubicacion_garita');
            $table->text('descripcion_garita')->nullable();
            $table->string('horario')->nullable();
            
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('set null');

            $table->string('contacto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garitas');
    }
};
