<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->unsignedInteger('stock')->default(0);
            $table->decimal('precio_proveedor', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
