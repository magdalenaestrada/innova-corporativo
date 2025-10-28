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
        Schema::create('detalle_nota_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("nota_pedido_id")->references("id")->on("nota_pedidos");
            $table->decimal( 'cantidad', 8, 2);
            $table->foreignId("producto_id")->references("id")->on("productos");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_nota_pedido');
    }
};
