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
        Schema::create('receta_medicamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receta_id')->constrained('recetas');
            $table->foreignId('medicamento_id')->constrained('medicamentos');
            $table->string('dosis');
            $table->string('frecuencia');
            $table->string('duracion');
            $table->text('instrucciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_medicamentos');
    }
};
