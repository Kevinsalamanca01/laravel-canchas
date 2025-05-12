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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');  // Definir la clave primaria como 'id_usuario'
            $table->string('nombre', 100)->nullable();  // Agregar columna 'nombre'
            $table->string('correo', 100)->nullable();  // Agregar columna 'correo'
            $table->string('telefono', 20)->nullable();  // Agregar columna 'telefono'
            $table->timestamps();  // Agregar los campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
