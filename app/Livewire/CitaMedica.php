<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Receta;
use App\Models\RecetaMedicamento;
use App\Models\Medicamento;
use App\Models\Doctor;
use App\Models\Cita;
use Illuminate\Support\Facades\DB;

class CitaMedica extends Component
{
    public $citaId;
    public $receta;
    public $medicamentos;
    public $medicamentosRecetados = [];
    
 
    public $indicaciones = '';
  
    public $medicamento_id = '';
    public $dosis = '';
    public $frecuencia = '';
    public $duracion = '';
    public $instrucciones = '';
    
  
    public $mostrarModal = false;
    public $medicamentoEditando = null;

    public function mount($citaId)
    {
        $this->citaId = $citaId;
        $this->medicamentos = Medicamento::with(['via', 'efecto'])
            ->orderBy('nombre_generico')
            ->get();
        
        $this->cargarReceta();
    }

    public function cargarReceta()
    {
        $doctorId = Doctor::where('user_id', auth()->id())->first()?->id;
        $cita = Cita::find($this->citaId);

        // Buscar receta existente
        $this->receta = Receta::where('cita_id', $this->citaId)
            ->where('doctor_id', $doctorId)
            ->first();

        if ($this->receta) {
            $this->indicaciones = $this->receta->indicaciones;
            
            // Cargar medicamentos recetados
            $this->medicamentosRecetados = RecetaMedicamento::where('receta_id', $this->receta->id)
                ->with('medicamento.via', 'medicamento.efecto')
                ->get()
                ->toArray();
        } else {
            $this->medicamentosRecetados = [];
        }
    }

    public function crearReceta()
    {
        $this->validate([
            'indicaciones' => 'required|string|min:10',
        ], [
            'indicaciones.required' => 'Las indicaciones son obligatorias',
            'indicaciones.min' => 'Las indicaciones deben tener al menos 10 caracteres',
        ]);

        $doctorId = Doctor::where('user_id', auth()->id())->first()->id;
        $cita = Cita::find($this->citaId);

        $this->receta = Receta::create([
            'paciente_id' => $cita->paciente_id,
            'doctor_id' => $doctorId,
            'cita_id' => $this->citaId,
            'indicaciones' => $this->indicaciones,
        ]);

        session()->flash('success', 'Receta creada correctamente.');
        $this->cargarReceta();
    }

    public function actualizarIndicaciones()
    {
        if (!$this->receta) {
            session()->flash('error', 'Primero debes crear la receta.');
            return;
        }

        $this->validate([
            'indicaciones' => 'required|string|min:10',
        ]);

        $this->receta->update([
            'indicaciones' => $this->indicaciones,
        ]);

        session()->flash('success', 'Indicaciones actualizadas correctamente.');
    }

    public function abrirModalAgregar()
    {
        if (!$this->receta) {
            session()->flash('error', 'Primero debes crear la receta con indicaciones.');
            return;
        }

        $this->resetearFormularioMedicamento();
        $this->medicamentoEditando = null;
        $this->mostrarModal = true;
    }

    public function abrirModalEditar($id)
    {
        $recetaMed = RecetaMedicamento::with('medicamento')->findOrFail($id);
        
        $this->medicamentoEditando = $recetaMed->id;
        $this->medicamento_id = $recetaMed->medicamento_id;
        $this->dosis = $recetaMed->dosis;
        $this->frecuencia = $recetaMed->frecuencia;
        $this->duracion = $recetaMed->duracion;
        $this->instrucciones = $recetaMed->instrucciones;
        
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
        $this->resetearFormularioMedicamento();
    }

    public function resetearFormularioMedicamento()
    {
        $this->reset(['medicamento_id', 'dosis', 'frecuencia', 'duracion', 'instrucciones', 'medicamentoEditando']);
        $this->resetValidation();
    }

    public function guardarMedicamento()
    {
        $this->validate([
            'medicamento_id' => 'required|exists:medicamentos,id',
            'dosis' => 'required|string|max:255',
            'frecuencia' => 'required|string|max:255',
            'duracion' => 'required|string|max:255',
            'instrucciones' => 'nullable|string|max:500',
        ], [
            'medicamento_id.required' => 'Selecciona un medicamento',
            'dosis.required' => 'La dosis es obligatoria',
            'frecuencia.required' => 'La frecuencia es obligatoria',
            'duracion.required' => 'La duración es obligatoria',
        ]);

        if ($this->medicamentoEditando) {
            // Actualizar
            $recetaMed = RecetaMedicamento::findOrFail($this->medicamentoEditando);
            $recetaMed->update([
                'medicamento_id' => $this->medicamento_id,
                'dosis' => $this->dosis,
                'frecuencia' => $this->frecuencia,
                'duracion' => $this->duracion,
                'instrucciones' => $this->instrucciones,
            ]);
            session()->flash('success', 'Medicamento actualizado correctamente.');
        } else {
            // Crear
            RecetaMedicamento::create([
                'receta_id' => $this->receta->id,
                'medicamento_id' => $this->medicamento_id,
                'dosis' => $this->dosis,
                'frecuencia' => $this->frecuencia,
                'duracion' => $this->duracion,
                'instrucciones' => $this->instrucciones,
            ]);
            session()->flash('success', 'Medicamento agregado correctamente.');
        }

        $this->cerrarModal();
        $this->cargarReceta();
    }

    public function eliminarMedicamento($id)
    {
        $recetaMed = RecetaMedicamento::findOrFail($id);
        $recetaMed->delete();
        
        session()->flash('success', 'Medicamento eliminado correctamente.');
        $this->cargarReceta();
    }

    public function render()
    {
        return view('livewire.cita-medica');
    }
}