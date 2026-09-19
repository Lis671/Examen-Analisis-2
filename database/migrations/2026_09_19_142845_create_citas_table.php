<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctores')->cascadeOnDelete();
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->string('motivo', 500)->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'cancelada', 'atendida'])
                ->index()
                ->default('pendiente');
            $table->timestamp('cancelada_en')->nullable();
            $table->timestamps();

            $table->index(['doctor_id', 'inicio', 'fin']);
            $table->index(['paciente_id']);
            $table->index('inicio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
