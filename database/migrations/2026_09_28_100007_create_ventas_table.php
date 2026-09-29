<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('realizacion');
            $table->decimal('total', 10, 2);
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->unsignedInteger('total_piezas');
            $table->string('estado_pago', 20)->default('PENDIENTE'); // PENDIENTE, PAGADO, PARCIAL, CANCELADO
            $table->string('metodo_pago', 20)->nullable();           // EFECTIVO, TRANSFERENCIA, TARJETA, CHEQUE
            $table->string('notas_pago')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
