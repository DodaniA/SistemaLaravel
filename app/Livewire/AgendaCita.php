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
    public function render()
    {
        return view('livewire.agenda-cita');
    }
    public function mount()
    {
        $this->doctores = Doctor::all();
    }


    public function crear()
    {
        $this->paciente_id = Paciente::where('user_id', auth()->id())->first()->id;
        
        $this->validate([
            'doctor_id'  => 'required|exists:doctores,id',
            'fecha_hora' => 'required|date',
            'motivo'     => 'required|string|max:255',
        ]);
        
        $clima = null;

        try {
            // Coordenadas de Slp
            $lat = 22.1516472;
            $lon = -100.9763993;
            
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'lat'   => $lat,
                'lon'   => $lon,
                'appid' => 'c3c992c75a065cacf3043ead890db375',
                'units' => 'metric',
                'lang'  => 'es',
            ]);
           
            if ($response->successful()) {
                $data = $response->json();
                $main        = $data['weather'][0]['main'] ?? '';           
                $descripcion = $data['weather'][0]['description'] ?? '';   
                $temp        = $data['main']['temp'] ?? null;               
                $feelsLike   = $data['main']['feels_like'] ?? null;         
                $icono       = $data['weather'][0]['icon'] ?? '';           
                $ciudad      = $data['name'] ?? '';                         // "San Luis Potosí City"
                $pais        = $data['sys']['country'] ?? '';               // "MX"
              
           
                $clima = json_encode([
                    'main'        => $main,
                    'descripcion' => $descripcion,
                    'temperatura' => $temp,
                    'sensacion'   => $feelsLike,
                    'icono'       => $icono,
                    'ciudad'      => $ciudad,
                    'pais'        => $pais,
                ]);
                
            } else {
                $clima = 'No disponible';
                       
            }
        } catch (\Throwable $e) {
            $clima = 'No disponible';
        }
  
        $cita=Cita::create([
            'paciente_id' => $this->paciente_id,            
            'doctor_id'   => $this->doctor_id,
            'fecha_hora'  => $this->fecha_hora,
            'estado'      => 'pendiente',            
            'motivo'      => $this->motivo,
            'clima'       => $clima,
        ]);
        Mail::to(auth()->user()->email)->send(new CitaCreada($cita));
        $this->reset([ 'fecha_hora', 'motivo']);
        session()->flash('success', 'Cita creada correctamente.');
    }
}
