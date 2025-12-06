<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Calificacion;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class EstadisticaCal extends Component
{
    public $labels = ['★', '★★', '★★★', '★★★★', '★★★★★'];
    public $datos = [];
    public $totalCalificaciones = 0;
    public $promedioCalificacion = 0;
    public $mejorCalificacion = 0;
    public $peorCalificacion = 0;
    public $doctorId = null;

    public function mount($doctorId = null)
    {
        
        $this->doctorId = $doctorId;
       
        $this->cargarEstadisticas();
    }
    

    public function cargarEstadisticas()
    {   
        if (!$this->doctorId) {
            $doctor = Doctor::where('user_id', auth()->id())->first();
            if ($doctor) {
                $this->doctorId = $doctor->id;
            } else {
                $this->datos = [0, 0, 0, 0, 0];
                return;
            }
        }
        
        $this->datos = [
            Calificacion::where('doctor_id', $this->doctorId)->where('calificacion', 1)->count(),
            Calificacion::where('doctor_id', $this->doctorId)->where('calificacion', 2)->count(),
            Calificacion::where('doctor_id', $this->doctorId)->where('calificacion', 3)->count(),
            Calificacion::where('doctor_id', $this->doctorId)->where('calificacion', 4)->count(),
            Calificacion::where('doctor_id', $this->doctorId)->where('calificacion', 5)->count(),
        ];

        $calificaciones = Calificacion::where('doctor_id', $this->doctorId)->pluck('calificacion');
        
        $this->totalCalificaciones = $calificaciones->count();
        $this->promedioCalificacion = $this->totalCalificaciones > 0 
            ? round($calificaciones->avg(), 2) 
            : 0;
        $this->mejorCalificacion = $this->totalCalificaciones > 0 
            ? $calificaciones->max() 
            : 0;
        $this->peorCalificacion = $this->totalCalificaciones > 0 
            ? $calificaciones->min() 
            : 0;

        $this->dispatch('actualizarGraficoCalificaciones', [
            'labels' => $this->labels,
            'datos' => $this->datos
        ]);
    }

    public function render()
    {
        return view('livewire.estadistica-cal');
    }
}