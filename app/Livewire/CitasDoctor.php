<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cita;
use App\Models\Doctor;
use Carbon\Carbon;

class CitasDoctor extends Component
{
    public $citas;

    public function mount()
    {
        $this->actualizarEstados();
        $this->cargarCitas();
    }

    protected function doctorId(): ?int
    {
        return Doctor::where('user_id', auth()->id())->value('id');
    }

    public function cargarCitas()
    {
        $doctorId = $this->doctorId();

        if ($doctorId) {
            $this->citas = Cita::with(['paciente.user'])
                ->where('doctor_id', $doctorId)
                ->select('id', 'doctor_id', 'paciente_id', 'fecha_hora', 'estado', 'motivo')
                ->orderBy('fecha_hora', 'desc')
                ->get();
        } else {
            $this->citas = collect();
        }
    }

    public function actualizarEstados()
    {
        $doctorId = $this->doctorId();

        if ($doctorId) {
            
            Cita::where('doctor_id', $doctorId)
                ->where('estado', 'pendiente')
                ->where('fecha_hora', '<', Carbon::now())
                ->update(['estado' => 'completada']);

      
            Cita::withTrashed()
                ->where('doctor_id', $doctorId)
                ->whereNotNull('deleted_at')
                ->where('estado', '!=', 'cancelada')
                ->where('estado', '!=', 'completada')
                ->update(['estado' => 'cancelada']);
        }

        $this->cargarCitas();
    }

    public function eliminar($citaId)
    {
        $doctorId = $this->doctorId();

        $cita = Cita::where('id', $citaId)
            ->where('doctor_id', $doctorId)
            ->first();

        if ($cita) {
            $cita->delete();
            session()->flash('success', 'Cita cancelada correctamente.');
            $this->cargarCitas();
        } else {
            session()->flash('error', 'No se pudo cancelar la cita.');
        }
    }


    public function atender($citaId)
    {
        $doctorId = $this->doctorId();

        $cita = Cita::where('id', $citaId)
            ->where('doctor_id', $doctorId)
            ->firstOrFail();


        return redirect()->route('atender', $cita->id);
    }

    public function render()
    {
        return view('livewire.citas-doctor');
    }
}
