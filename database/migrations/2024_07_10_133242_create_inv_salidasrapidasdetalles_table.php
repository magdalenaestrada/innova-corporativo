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
        Schema::create('inv_salidasrapidasdetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inv_salidasrapidas_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('cantidad');

            $table->foreign('inv_salidasrapidas_id')->references('id')->on('inv_salidasrapidas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_salidasrapidasdetalles');
    }
};
