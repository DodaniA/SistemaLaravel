<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Cita;
use Livewire\Component;
use App\Models\Paciente;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Mail;
use App\Mail\CitaCreada;

class AgendaCita extends Component
{
    public $doctores = [];
    public $doctor_id;
    public $paciente_id;
    public $fecha_hora;
    public $motivo;
    
    public function mount()
    {
        // Cargamos doctores con su info
        $this->doctores = Doctor::with('especialidad', 'user')->get();
    }

    public function crear()
    {
        // Primero revisamos que el usuario tenga perfil de paciente
        $paciente = Paciente::where('user_id', auth()->id())->first();
        
        if (!$paciente) {
            session()->flash('error', 'Necesitas completar tu perfil primero.');
            return;
        }

        $this->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'fecha_hora' => 'required|date|after:now',
            'motivo' => 'required|string|max:255',
        ]);

        
        $clima = $this->traerClima();

        $cita = Cita::create([
            'paciente_id' => $paciente->id,
            'doctor_id' => $this->doctor_id,
            'fecha_hora' => $this->fecha_hora,
            'estado' => 'pendiente',
            'motivo' => $this->motivo,
            'clima' => $clima,
        ]);

        // Mandamos el email de confirmación
        $cita->load('doctor.user');
        Mail::to(auth()->user()->email)->send(new CitaCreada($cita));
        
        $this->reset(['fecha_hora', 'motivo']);
        session()->flash('success', '¡Listo! Cita agendada correctamente.');
    }

    private function traerClima()
    {
        try {
            $response = Http::timeout(5)->get('https://api.openweathermap.org/data/2.5/weather', [
                'lat' => 22.1516472,
                'lon' => -100.9763993,
                'appid' => 'c3c992c75a065cacf3043ead890db375',
                'units' => 'metric',
                'lang' => 'es',
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $weather = $data['weather'][0] ?? [];
            $main = $data['main'] ?? [];

            return json_encode([
                'main' => $weather['main'] ?? '',
                'descripcion' => $weather['description'] ?? '',
                'temperatura' => $main['temp'] ?? null,
                'sensacion' => $main['feels_like'] ?? null,
                'icono' => $weather['icon'] ?? '',
                'ciudad' => $data['name'] ?? '',
                'pais' => $data['sys']['country'] ?? ''
            ]);
        } catch (\Exception $e) {
            // Por si falla la API del clima
            \Log::warning('Error clima: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.agenda-cita');
    }
}