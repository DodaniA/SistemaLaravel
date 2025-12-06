<?php

namespace App\Livewire;

use App\Models\Doctor;
use App\Models\Especialidad;
use Livewire\Component;

class FormularioMedico extends Component
{
    public $especialidades = [];

    public $especialidad_id;
    public $cedula_profesional;
    public $descripcion;

    public function mount()
    {
        $this->especialidades = Especialidad::all();
    }

    public function render()
    {
        return view('livewire.formulario-medico');
    }

    public function crear()
    {
        $this->validate([
            'especialidad_id'     => 'required|exists:especialidades,id',
            'cedula_profesional'  => 'required|unique:doctores,cedula_profesional',
            'descripcion'         => 'nullable|string|max:255',
        ]);

        Doctor::create([
            'user_id'            => auth()->id(),
            'especialidad_id'    => $this->especialidad_id,
            'cedula_profesional' => $this->cedula_profesional,
            'descripcion'        => $this->descripcion,
        ]);

        $this->reset(['especialidad_id', 'cedula_profesional', 'descripcion']);

        session()->flash('success', 'Información guardada correctamente.');
        return redirect()->to('/dashboard');
    }
}
