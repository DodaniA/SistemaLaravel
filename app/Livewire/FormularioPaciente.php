<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\GrupoSanguineo;
class FormularioPaciente extends Component
{
    public $grupos_sanguineos = [];
    public $alergias;
    public $diagnosticos_previos;
    public $grupo_sanguineo_id;

    public function render()
    {
        return view('livewire.formulario-paciente');
    }
     public function mount()
    {
        $this->grupos_sanguineos = GrupoSanguineo::all();
    }
    public function crear()
    {
        $this->validate([
            'grupo_sanguineo_id'     => 'required|exists:grupos_sanguineos,id',
            'alergias'  => 'nullable|string|max:255',
            'diagnosticos_previos'         => 'nullable|string|max:255',
        ]);

        Paciente::create([
            'user_id'=> auth()->id(),
            'grupo_sanguineo_id'=> $this->grupo_sanguineo_id,
            'alergias' => $this->alergias,
            'diagnosticos_previos'=> $this->diagnosticos_previos,
        ]);

        $this->reset(['grupo_sanguineo_id', 'alergias', 'diagnosticos_previos']);
        session()->flash('success', 'Información guardada correctamente.');
        return redirect()->to('/dashboard');
    }
}
