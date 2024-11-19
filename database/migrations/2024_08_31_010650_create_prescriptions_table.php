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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Fecha de la prescripción
            $table->string('medicine_name'); // Nombre del medicamento
            $table->string('dosage'); // Dosis prescrita
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade'); // Relación con la tabla de mascotas (pacientes)
            $table->foreignId('veterinarian_id')->constrained('veterinarians')->onDelete('cascade'); // Relación con la tabla de veterinarios
            $table->text('instructions')->nullable(); // Instrucciones adicionales
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
