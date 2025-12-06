<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cita;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Agenda extends Component
{
    public $citas;

    public function mount()
    {
        $this->cargarCitas();
        $this->actualizarEstados();
    }

    public function cargarCitas()
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        if ($pacienteId) {
            $this->citas = Cita::with(['doctor.user', 'doctor.especialidad'])
                ->where('paciente_id', $pacienteId)
                ->select('id', 'doctor_id', 'fecha_hora', 'estado', 'motivo', 'paciente_id')
                ->orderBy('fecha_hora', 'desc')
                ->get();
        } else {
            $this->citas = collect();
        }
    }

    public function actualizarEstados()
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        if ($pacienteId) {
            
            Cita::where('paciente_id', $pacienteId)
                ->where('estado', 'pendiente')
                ->where('fecha_hora', '<', Carbon::now())
                ->update(['estado' => 'completada']);

            Cita::withTrashed() 
            ->where('paciente_id', $pacienteId)
            ->whereNotNull('deleted_at')
            ->where('estado', '!=', 'cancelada')
            ->where('estado','!=','completada') 
            ->update(['estado' => 'cancelada']);
        }
        $this->cargarCitas();
    }

    public function eliminar($citaId)
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        $cita = Cita::where('id', $citaId)
            ->where('paciente_id', $pacienteId)
            ->first();

        if ($cita) {
            $cita->delete();
            session()->flash('success', 'Cita eliminada correctamente.');
            $this->cargarCitas();
        } else {
            session()->flash('error', 'No se pudo eliminar la cita.');
        }
    }

    public function render()
    {
        return view('livewire.agenda');
    }
}