<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Paciente;
use App\Models\Medicamento;
use App\Models\Cita;
use App\Models\Receta;
use App\Models\RecetaMedicamento;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // ============================
            // USERS PRINCIPALES
            // ============================
            $doctorUser = User::firstOrCreate(
                ['email' => 'doctor@ejemplo.com'],
                [
                    'name'     => 'Dr. Juan Pérez',
                    'password' => Hash::make('password'),
                    'role'     => 'Medico', 
                ]
            );

            $pacienteUser = User::firstOrCreate(
                ['email' => 'paciente@ejemplo.com'],
                [
                    'name'     => 'Paciente Demo',
                    'password' => Hash::make('password'),
                    'role'     => 'Paciente', 
                ]
            );

            // ============================
            // USERS ADICIONALES
            // ============================
            $doctorUser2 = User::firstOrCreate(
                ['email' => 'cardiologo@ejemplo.com'],
                [
                    'name'     => 'Dra. María López',
                    'password' => Hash::make('password'),
                    'role'     => 'Medico',
                ]
            );

            $doctorUser3 = User::firstOrCreate(
                ['email' => 'pediatra@ejemplo.com'],
                [
                    'name'     => 'Dr. Carlos Ruiz',
                    'password' => Hash::make('password'),
                    'role'     => 'Medico',
                ]
            );

            $pacienteUser2 = User::firstOrCreate(
                ['email' => 'paciente2@ejemplo.com'],
                [
                    'name'     => 'Ana García',
                    'password' => Hash::make('password'),
                    'role'     => 'Paciente',
                ]
            );

            $pacienteUser3 = User::firstOrCreate(
                ['email' => 'paciente3@ejemplo.com'],
                [
                    'name'     => 'Luis Hernández',
                    'password' => Hash::make('password'),
                    'role'     => 'Paciente',
                ]
            );

            // ============================
            // DOCTORES
            // ============================
            $doctor = Doctor::firstOrCreate(
                ['user_id' => $doctorUser->id],
                [
                    'especialidad_id'    => 1, // Medicina General
                    'descripcion'        => 'Médico general con enfoque en atención integral.',
                    'cedula_profesional' => '12345678',
                ]
            );

            $doctor2 = Doctor::firstOrCreate(
                ['user_id' => $doctorUser2->id],
                [
                    'especialidad_id'    => 2, // Cardiología
                    'descripcion'        => 'Cardióloga especializada en prevención y control de riesgo cardiovascular.',
                    'cedula_profesional' => '87654321',
                ]
            );

            $doctor3 = Doctor::firstOrCreate(
                ['user_id' => $doctorUser3->id],
                [
                    'especialidad_id'    => 4, // Pediatría
                    'descripcion'        => 'Pediatra con experiencia en atención a niños y adolescentes.',
                    'cedula_profesional' => '11223344',
                ]
            );

            // ============================
            // PACIENTES
            // ============================
            $paciente = Paciente::firstOrCreate(
                ['user_id' => $pacienteUser->id],
                [
                    'grupo_sanguineo_id'   => 5, // O+
                    'diagnosticos_previos' => 'Hipertensión arterial controlada.',
                    'alergias'             => 'Penicilina',
                ]
            );

            $paciente2 = Paciente::firstOrCreate(
                ['user_id' => $pacienteUser2->id],
                [
                    'grupo_sanguineo_id'   => 1, // A+
                    'diagnosticos_previos' => 'Migraña crónica.',
                    'alergias'             => 'Ninguna conocida',
                ]
            );

            $paciente3 = Paciente::firstOrCreate(
                ['user_id' => $pacienteUser3->id],
                [
                    'grupo_sanguineo_id'   => 7, // AB+
                    'diagnosticos_previos' => 'Diabetes tipo 2 y sobrepeso.',
                    'alergias'             => 'Aspirina',
                ]
            );

            // ============================
            // MEDICAMENTOS
            // ============================
            $paracetamol = Medicamento::firstOrCreate(
                ['nombre_generico' => 'Paracetamol'],
                [
                    'via_id'        => 1, // Oral
                    'efecto_id'     => 1, // Analgésico
                    'concentracion' => '500 mg',
                ]
            );

            $ibuprofeno = Medicamento::firstOrCreate(
                ['nombre_generico' => 'Ibuprofeno'],
                [
                    'via_id'        => 1, // Oral
                    'efecto_id'     => 2, // Antiinflamatorio
                    'concentracion' => '400 mg',
                ]
            );

            $amoxicilina = Medicamento::firstOrCreate(
                ['nombre_generico' => 'Amoxicilina'],
                [
                    'via_id'        => 1, // Oral
                    'efecto_id'     => 3, // Antibiótico
                    'concentracion' => '500 mg',
                ]
            );

            $loratadina = Medicamento::firstOrCreate(
                ['nombre_generico' => 'Loratadina'],
                [
                    'via_id'        => 1, // Oral
                    'efecto_id'     => 4, // Antihistamínico
                    'concentracion' => '10 mg',
                ]
            );

            $omeprazol = Medicamento::firstOrCreate(
                ['nombre_generico' => 'Omeprazol'],
                [
                    'via_id'        => 1, // Oral
                    'efecto_id'     => 1, // Lo usamos como ejemplo, ajusta si quieres otro efecto
                    'concentracion' => '20 mg',
                ]
            );

            $now = Carbon::now();

            // ============================
            // CITAS DOCTOR PRINCIPAL
            // ============================
            // Cita pasada
            $citaPasada = Cita::create([
                'paciente_id' => $paciente->id,
                'doctor_id'   => $doctor->id,
                'fecha_hora'  => $now->copy()->subDays(2)->setTime(10, 0),
                'estado'      => 'pendiente',
            ]);

            // Cita futura
            $citaFutura = Cita::create([
                'paciente_id' => $paciente->id,
                'doctor_id'   => $doctor->id,
                'fecha_hora'  => $now->copy()->addDays(3)->setTime(9, 30),
                'estado'      => 'pendiente',
            ]);

            // Otra cita futura diferente hora
            $citaFutura2 = Cita::create([
                'paciente_id' => $paciente->id,
                'doctor_id'   => $doctor->id,
                'fecha_hora'  => $now->copy()->addDays(10)->setTime(16, 0),
                'estado'      => 'pendiente',
            ]);

            // ============================
            // CITAS DOCTOR 2 (Cardióloga)
            // ============================
            $citaCardioPasada = Cita::create([
                'paciente_id' => $paciente2->id,
                'doctor_id'   => $doctor2->id,
                'fecha_hora'  => $now->copy()->subDays(5)->setTime(11, 30),
                'estado'      => 'completada',
            ]);

            $citaCardioFutura = Cita::create([
                'paciente_id' => $paciente2->id,
                'doctor_id'   => $doctor2->id,
                'fecha_hora'  => $now->copy()->addDays(1)->setTime(8, 0),
                'estado'      => 'confirmada',
            ]);

            // ============================
            // CITAS DOCTOR 3 (Pediatra)
            // ============================
            $citaPediatraPasada = Cita::create([
                'paciente_id' => $paciente3->id,
                'doctor_id'   => $doctor3->id,
                'fecha_hora'  => $now->copy()->subDays(1)->setTime(15, 0),
                'estado'      => 'completada',
            ]);

            $citaPediatraFutura = Cita::create([
                'paciente_id' => $paciente3->id,
                'doctor_id'   => $doctor3->id,
                'fecha_hora'  => $now->copy()->addDays(7)->setTime(12, 0),
                'estado'      => 'pendiente',
            ]);

            // ============================
            // RECETA PRINCIPAL (citaPasada)
            // ============================
            $receta = Receta::create([
                'paciente_id'  => $paciente->id,
                'doctor_id'    => $doctor->id,
                'cita_id'      => $citaPasada->id,
                'indicaciones' => 'Tomar los medicamentos después de los alimentos y mantenerse hidratado.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $receta->id,
                'medicamento_id' => $paracetamol->id,
                'dosis'          => '1 tableta',
                'frecuencia'     => 'Cada 8 horas',
                'duracion'       => '3 días',
                'instrucciones'  => 'Suspender en caso de malestar gástrico fuerte.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $receta->id,
                'medicamento_id' => $ibuprofeno->id,
                'dosis'          => '1 tableta',
                'frecuencia'     => 'Cada 12 horas',
                'duracion'       => '5 días',
                'instrucciones'  => 'No usar en ayunas.',
            ]);

            // ============================
            // RECETA CARDIÓLOGA (citaCardioPasada)
            // ============================
            $recetaCardio = Receta::create([
                'paciente_id'  => $paciente2->id,
                'doctor_id'    => $doctor2->id,
                'cita_id'      => $citaCardioPasada->id,
                'indicaciones' => 'Reducir consumo de sal, hacer ejercicio ligero diario y seguir el tratamiento indicado.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $recetaCardio->id,
                'medicamento_id' => $amoxicilina->id,
                'dosis'          => '1 cápsula',
                'frecuencia'     => 'Cada 8 horas',
                'duracion'       => '7 días',
                'instrucciones'  => 'Completar el tratamiento aunque desaparezcan los síntomas.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $recetaCardio->id,
                'medicamento_id' => $omeprazol->id,
                'dosis'          => '1 cápsula',
                'frecuencia'     => 'Cada 24 horas',
                'duracion'       => '14 días',
                'instrucciones'  => 'Tomar en ayunas con un vaso de agua.',
            ]);

            // ============================
            // RECETA PEDIATRA (citaPediatraPasada)
            // ============================
            $recetaPediatra = Receta::create([
                'paciente_id'  => $paciente3->id,
                'doctor_id'    => $doctor3->id,
                'cita_id'      => $citaPediatraPasada->id,
                'indicaciones' => 'Vigilar temperatura, mantener hidratación y acudir a urgencias si hay dificultad para respirar.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $recetaPediatra->id,
                'medicamento_id' => $paracetamol->id,
                'dosis'          => '½ tableta',
                'frecuencia'     => 'Cada 6 horas',
                'duracion'       => '3 días',
                'instrucciones'  => 'Ajustar dosis según peso del paciente.',
            ]);

            RecetaMedicamento::create([
                'receta_id'      => $recetaPediatra->id,
                'medicamento_id' => $loratadina->id,
                'dosis'          => '1 cucharadita',
                'frecuencia'     => 'Cada 24 horas',
                'duracion'       => '5 días',
                'instrucciones'  => 'Tomar preferentemente por la noche.',
            ]);
        });
    }
}
