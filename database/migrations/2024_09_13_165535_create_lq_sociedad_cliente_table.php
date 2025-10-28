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
        Schema::create('lq_sociedad_cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('sociedad_id');
            $table->unsignedBigInteger('creador_id');
            
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('lq_clientes')->onDelete('restrict');
            $table->foreign('sociedad_id')->references('id')->on('lq_sociedades')->onDelete('restrict');
            $table->foreign('creador_id')->references('id')->on('users')->onDelete('restrict');
     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lq_sociedad_cliente');
    }
};
