<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MedicamentosImport;

class ImporteMedExcel extends Component
{
    use WithFileUploads;

    public $archivo;
    public $importando = false;
    public $errores = [];

    public function importar()
    {
        $this->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ]);

        $this->importando = true;
        $this->errores = [];

        try {
            $import = new MedicamentosImport();
            
            Excel::import($import, $this->archivo->getRealPath());

            if (!empty($import->errores)) {
                $this->errores = $import->errores;
                session()->flash('warning', 'Importación completada con algunos errores.');
            } else {
                session()->flash('success', 'Medicamentos importados correctamente.');
                $this->reset('archivo');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Error al importar: ' . $e->getMessage());
        } finally {
            $this->importando = false;
        }
    }

    public function descargarPlantilla()
    {
        // Crear un archivo Excel de ejemplo
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="plantilla_medicamentos.csv"',
        ];

        $columns = ['nombre_generico', 'via_administracion', 'efecto', 'concentracion'];
        $ejemplo = [
            ['Paracetamol', 'Oral', 'Analgésico', '500mg'],
            ['Ibuprofeno', 'Oral', 'Antiinflamatorio', '400mg'],
            ['Amoxicilina', 'Oral', 'Antibiótico', '500mg'],
        ];

        $callback = function() use ($columns, $ejemplo) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($ejemplo as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        return view('livewire.importe-med-excel');
    }
}