<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_pedidos', function (Blueprint $table) {
            $table->id();
            $table->date("fecha_creacion");
            $table->string('codigo')->unique();
            $table->string('dni')->nullable();
            $table->string('conductor')->nullable();
            $table->string('telefono')->nullable();
            $table->string('placa_vehiculo')->nullable();
            $table->string('descripcion')->nullable();
            $table->decimal('kilometraje', 10, 1)->nullable();
            $table->foreignId("usuario_id")->references("id")->on("users");
            $table->foreignId('encargado_id')->nullable()->constrained('empleados')->nullOnDelete();
            $table->enum("estado", ["A", "I"])->default("I");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notas_pedido');
    }
};
