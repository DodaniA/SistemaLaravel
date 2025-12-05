<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Medicamento;
use App\Models\ViaAdministracion;
use App\Models\Efecto;

class GestionMedicamentos extends Component
{
    public $medicamentos;
    public $vias;
    public $efectos;
 
    public $medicamento_id = null;
    public $nombre_generico = '';
    public $via_id = '';
    public $efecto_id = '';
    public $concentracion = '';
    
   
    public $mostrarModal = false;
    public $modoEdicion = false;

    public function mount()
    {
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        $this->medicamentos = Medicamento::with(['via', 'efecto'])
            ->orderBy('nombre_generico')
            ->get();
        $this->vias = ViaAdministracion::orderBy('nombre')->get();
        $this->efectos = Efecto::orderBy('nombre')->get();
    }

    public function abrirModalCrear()
    {
        $this->resetearFormulario();
        $this->modoEdicion = false;
        $this->mostrarModal = true;
    }

    public function abrirModalEditar($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        
        $this->medicamento_id = $medicamento->id;
        $this->nombre_generico = $medicamento->nombre_generico;
        $this->via_id = $medicamento->via_id;
        $this->efecto_id = $medicamento->efecto_id;
        $this->concentracion = $medicamento->concentracion;
        
        $this->modoEdicion = true;
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetearFormulario();
    }

    public function resetearFormulario()
    {
        $this->reset([
            'medicamento_id',
            'nombre_generico',
            'via_id',
            'efecto_id',
            'concentracion'
        ]);
        $this->resetValidation();
    }

    public function guardar()
    {
        $this->validate([
            'nombre_generico' => 'required|string|max:255',
            'via_id' => 'required|exists:vias_administracion,id',
            'efecto_id' => 'required|exists:efectos,id',
            'concentracion' => 'required|string|max:255',
        ]);

        if ($this->modoEdicion) {
            $medicamento = Medicamento::findOrFail($this->medicamento_id);
            $medicamento->update([
                'nombre_generico' => $this->nombre_generico,
                'via_id' => $this->via_id,
                'efecto_id' => $this->efecto_id,
                'concentracion' => $this->concentracion,
            ]);
            session()->flash('success', 'Medicamento actualizado correctamente.');
        } else {
            Medicamento::create([
                'nombre_generico' => $this->nombre_generico,
                'via_id' => $this->via_id,
                'efecto_id' => $this->efecto_id,
                'concentracion' => $this->concentracion,
            ]);
            session()->flash('success', 'Medicamento creado correctamente.');
        }

        $this->cerrarModal();
        $this->cargarDatos();
    }

    public function eliminar($id)
    {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->delete();
        
        session()->flash('success', 'Medicamento eliminado correctamente.');
        $this->cargarDatos();
    }

    public function render()
    {
        return view('livewire.gestion-medicamentos');
    }
}