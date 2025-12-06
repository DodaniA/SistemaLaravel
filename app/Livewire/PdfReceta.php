<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Receta;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfReceta extends Component
{
    public $recetas;

    public function mount()
    {
        $this->cargarRecetas();
    }

    public function cargarRecetas()
    {
        $pacienteId = Paciente::where('user_id', auth()->id())->first()?->id;

        if ($pacienteId) {
            $this->recetas = Receta::with([
                'doctor.user',
                'doctor.especialidad',
                'medicamentos.medicamento.via',
                'medicamentos.medicamento.efecto',
                'cita'
            ])
            ->where('paciente_id', $pacienteId)
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $this->recetas = collect();
        }
    }

    public function descargarPDF($recetaId)
    {
        $receta = Receta::with([
            'paciente.user',
            'doctor.user',
            'doctor.especialidad',
            'medicamentos.medicamento.via',
            'medicamentos.medicamento.efecto',
            'cita'
        ])->findOrFail($recetaId);

        $pdf = Pdf::loadView('pdf', ['receta' => $receta]);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'receta-' . $recetaId . '.pdf');
    }

    public function render()
    {
        return view('livewire.pdf-receta');
    }
}