<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $doctores = [
            Doctor::create(['nombre' => 'Dra. Ana Gómez', 'especialidad' => 'Medicina General', 'email' => 'ana.gomez@clinica.test']),
            Doctor::create(['nombre' => 'Dr. Luis Pérez', 'especialidad' => 'Cardiología', 'email' => 'luis.perez@clinica.test']),
            Doctor::create(['nombre' => 'Dra. María López', 'especialidad' => 'Pediatría', 'email' => 'maria.lopez@clinica.test']),
        ];

        $pacientes = [
            Paciente::create(['nombre' => 'Juan Rodríguez', 'telefono' => '5555-0101', 'email' => 'juan.rodriguez@mail.com']),
            Paciente::create(['nombre' => 'María Pérez', 'telefono' => '5555-0102', 'email' => 'maria.perez@mail.com']),
            Paciente::create(['nombre' => 'Carlos López', 'telefono' => '5555-0103']),
            Paciente::create(['nombre' => 'Ana Martínez', 'telefono' => '5555-0104', 'email' => 'ana.martinez@mail.com']),
        ];

        $hoy = now()->startOfDay();

        $citas = [
            ['doctor' => $doctores[0], 'paciente' => $pacientes[0], 'inicio' => $hoy->copy()->setTime(9, 0), 'fin' => $hoy->copy()->setTime(9, 30), 'motivo' => 'Consulta de control', 'estado' => 'confirmada'],
            ['doctor' => $doctores[1], 'paciente' => $pacientes[1], 'inicio' => $hoy->copy()->setTime(10, 0), 'fin' => $hoy->copy()->setTime(10, 30), 'motivo' => 'Chequeo cardiovascular', 'estado' => 'pendiente'],
            ['doctor' => $doctores[2], 'paciente' => $pacientes[2], 'inicio' => $hoy->copy()->addDay()->setTime(11, 0), 'fin' => $hoy->copy()->addDay()->setTime(11, 30), 'motivo' => 'Vacunación infantil', 'estado' => 'confirmada'],
            ['doctor' => $doctores[0], 'paciente' => $pacientes[3], 'inicio' => $hoy->copy()->addDay()->setTime(14, 0), 'fin' => $hoy->copy()->addDay()->setTime(14, 20), 'motivo' => 'Dolor abdominal', 'estado' => 'pendiente'],
        ];

        foreach ($citas as $c) {
            Cita::create([
                'doctor_id' => $c['doctor']->id,
                'paciente_id' => $c['paciente']->id,
                'inicio' => $c['inicio'],
                'fin' => $c['fin'],
                'motivo' => $c['motivo'],
                'estado' => $c['estado'],
            ]);
        }
    }
}
