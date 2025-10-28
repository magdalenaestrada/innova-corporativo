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
        Schema::create('lq_liquidaciones_adelantos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liquidacion_id');
            $table->unsignedBigInteger('adelanto_id');
            $table->timestamps();


            $table->foreign('liquidacion_id')->references('id')->on('lq_liquidaciones')->onDelete('restrict');
            $table->foreign('adelanto_id')->references('id')->on('lq_adelantos')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lq_liquidaciones_adelantos');
    }
};
