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
        Schema::create('notas_medicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained('citas')->nullable();
            $table->foreignId('paciente_id')->constrained('pacientes');
            $table->foreignId('doctor_id')->constrained('doctores');
            $table->text('nota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notas_medicas');
    }
};
