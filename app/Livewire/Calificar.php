<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Calificacion;

class Calificar extends Component
{
    public $citasCompletadas;
    public $citaSeleccionada = null;
    public $calificacion = 5;
    public $comentario = '';
    public $mostrarModal = false;

    public function mount()
    {
        $this->cargarCitasCompletadas();
    }

    public function cargarCitasCompletadas()
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        if ($pacienteId) {
            $this->citasCompletadas = Cita::with(['doctor.user', 'doctor.especialidad'])
                ->where('paciente_id', $pacienteId)
                ->where('estado', 'completada')
                ->whereDoesntHave('calificacion')
                ->orderBy('fecha_hora', 'desc')
                ->get();
        } else {
            $this->citasCompletadas = collect();
        }
    }

    public function abrirModal($citaId)
    {
        $this->citaSeleccionada = $citaId;
        $this->calificacion = 5;
        $this->comentario = '';
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->citaSeleccionada = null;
        $this->reset(['calificacion', 'comentario']);
    }

    public function guardarCalificacion()
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        $this->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        
        $cita = Cita::where('id', $this->citaSeleccionada)
            ->where('paciente_id', $pacienteId)
            ->where('estado', 'completada')
            ->first();

        if (!$cita) {
            session()->flash('error', 'No se puede calificar esta cita.');
            return;
        }

        
        $calificacionExistente = Calificacion::where('cita_id', $this->citaSeleccionada)->first();

        if ($calificacionExistente) {
            session()->flash('error', 'Esta cita ya ha sido calificada.');
            $this->cerrarModal();
            $this->cargarCitasCompletadas();
            return;
        }

        
        Calificacion::create([
            'doctor_id' => $cita->doctor_id,
            'paciente_id' => $pacienteId,
            'cita_id' => $this->citaSeleccionada,
            'calificacion' => $this->calificacion,
            'comentario' => $this->comentario,
        ]);

        session()->flash('success', 'Calificación guardada correctamente.');
        $this->cerrarModal();
        $this->cargarCitasCompletadas();
    }

    public function render()
    {
        return view('livewire.calificar');
    }
}