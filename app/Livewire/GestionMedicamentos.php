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
    public $med_id = null;
    public $nombre_generico = '';
    public $via_id = '';
    public $efecto_id = '';
    public $concentracion = '';
    public $mostrarModal = false;

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

    public function nuevo()
    {
        $this->limpiar();
        $this->mostrarModal = true;
    }

    public function editar($id)
    {
        $med = Medicamento::findOrFail($id);
        
        $this->med_id = $med->id;
        $this->nombre_generico = $med->nombre_generico;
        $this->via_id = $med->via_id;
        $this->efecto_id = $med->efecto_id;
        $this->concentracion = $med->concentracion;
        $this->mostrarModal = true;
    }

    public function cancelar()
    {
        $this->mostrarModal = false;
        $this->limpiar();
    }

    private function limpiar()
    {
        $this->reset(['med_id', 'nombre_generico', 'via_id', 'efecto_id', 'concentracion']);
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

        $existe = Medicamento::where('nombre_generico', $this->nombre_generico)
            ->where('concentracion', $this->concentracion)
            ->where('id', '!=', $this->med_id ?? 0)
            ->exists();

        if ($existe) {
            $this->addError('nombre_generico', 'Ya existe este medicamento con la misma concentración');
            return;
        }

        $medicamento = $this->med_id 
            ? Medicamento::findOrFail($this->med_id)
            : new Medicamento();

        $medicamento->fill([
            'nombre_generico' => $this->nombre_generico,
            'via_id' => $this->via_id,
            'efecto_id' => $this->efecto_id,
            'concentracion' => $this->concentracion,
        ])->save();

        // Mensaje según si es edición o creación
        if ($this->med_id) {
            session()->flash('success', 'Medicamento actualizado');
        } else {
            session()->flash('success', 'Medicamento creado exitosamente');
        }
        
        $this->cancelar();
        $this->cargarDatos();
    }

    // Eliminar un medicamento
    public function eliminar($id)
    {
        Medicamento::findOrFail($id)->delete();
        session()->flash('success', 'Medicamento eliminado');
        $this->cargarDatos();
    }

    public function render()
    {
        return view('livewire.gestion-medicamentos');
    }
}