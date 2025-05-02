<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('canchas', function (Blueprint $table) {
            $table->id('id_cancha'); 
            $table->string('nombre', 100);
            $table->string('ubicacion', 100);
            $table->string('tipo', 50);
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('canchas');
    }
};
