<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cita;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadisticaCitas extends Component
{
    public $labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    public $datos = [];
    public $totalCitas = 0;
    public $citasPendientes = 0;
    public $citasCompletadas = 0;
    public $citasCanceladas = 0;

    public function mount()
    {
        $this->cargarEstadisticas();
    }

    public function cargarEstadisticas()
    {
        $doctorId = Doctor::where('user_id', auth()->id())->first()?->id;

        if (!$doctorId) {
            $this->datos = array_fill(0, 12, 0); 
            return;
        }

        $this->totalCitas = Cita::where('doctor_id', $doctorId)->count();
        $this->citasPendientes = Cita::where('doctor_id', $doctorId)->where('estado', 'pendiente')->count();
        $this->citasCompletadas = Cita::where('doctor_id', $doctorId)->where('estado', 'completada')->count();
        $this->citasCanceladas = Cita::withTrashed()->where('doctor_id', $doctorId)->where('estado', 'cancelada')->count();

        $this->estadisticasPorMes($doctorId);

        $this->dispatch('actualizarGrafico', [
            'labels' => $this->labels,
            'datos' => $this->datos
        ]);
    }

    private function estadisticasPorMes($doctorId)
    {
        $yearActual = Carbon::now()->year;

        $this->datos = array_fill(0, 12, 0);

        $citas = Cita::where('doctor_id', $doctorId)
            ->whereYear('fecha_hora', $yearActual)
            ->get();

       
        foreach ($citas as $cita) {
            $mes = Carbon::parse($cita->fecha_hora)->month; 
            $this->datos[$mes - 1]++;
        }
    }

    public function render()
    {
        return view('livewire.estadistica-citas');
    }
}