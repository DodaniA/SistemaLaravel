<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctor;

class CardDoctores extends Component
{
    public $doctores;
    public $doctorSeleccionado = null;
    public $mostrarModal = false;

    public function mount()
    {
        $this->cargarDoctores();
    }

    // Obtener la lista de doctores disponibles
    public function cargarDoctores()
    {
        $this->doctores = Doctor::with(['user', 'especialidad'])
            ->orderBy('id')
            ->get();
    }

    public function abrirModal($doctorId)
    {
        $this->doctorSeleccionado = Doctor::with(['user', 'especialidad'])
            ->findOrFail($doctorId);
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->doctorSeleccionado = null;
    }

    public function render()
    {
        return view('livewire.card-doctores');
    }
}