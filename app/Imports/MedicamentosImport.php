<?php

namespace App\Imports;

use App\Models\Medicamento;
use App\Models\ViaAdministracion;
use App\Models\Efecto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class MedicamentosImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    public $errores = [];

    public function model(array $row)
    {
        $via = ViaAdministracion::firstOrCreate(['nombre' => trim($row['via_administracion'])]);
        $efecto = Efecto::firstOrCreate(['nombre' => trim($row['efecto'])]);

        return new Medicamento([
            'nombre_generico' => trim($row['nombre_generico']),
            'via_id' => $via->id,
            'efecto_id' => $efecto->id,
            'concentracion' => trim($row['concentracion']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre_generico' => 'required|max:255',
            'via_administracion' => 'required|max:255',
            'efecto' => 'required|max:255',
            'concentracion' => 'required|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.required' => 'Campo obligatorio',
            'nombre_generico.required' => 'Nombre requerido',
            'via_administracion.required' => 'Vía requerida',
            'efecto.required' => 'Efecto requerido',
            'concentracion.required' => 'Concentración requerida',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $f) {
            $this->errores[] = [
                'fila' => $f->row(),
                'campo' => $f->attribute(),
                'errores' => $f->errors(),
            ];
        }
    }
}