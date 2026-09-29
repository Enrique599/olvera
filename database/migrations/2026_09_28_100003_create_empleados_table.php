<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->string('apellido_paterno', 80);
            $table->string('telefono', 10)->unique();
            $table->string('direccion');
            $table->string('contrasena');
            $table->string('rol', 20)->default('vendedor'); // admin, vendedor, almacen, contador
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
