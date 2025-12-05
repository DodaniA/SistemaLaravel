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
        // Buscar o crear Vía de Administración
        $via = ViaAdministracion::firstOrCreate(
            ['nombre' => trim($row['via_administracion'])]
        );

        // Buscar o crear Efecto
        $efecto = Efecto::firstOrCreate(
            ['nombre' => trim($row['efecto'])]
        );

        return new Medicamento([
            'nombre_generico' => trim($row['nombre_generico']),
            'via_id'          => $via->id,
            'efecto_id'       => $efecto->id,
            'concentracion'   => trim($row['concentracion']),
        ]);
    }

    public function rules(): array
    {
        return [
            'nombre_generico'     => 'required|string|max:255',
            'via_administracion'  => 'required|string|max:255',
            'efecto'              => 'required|string|max:255',
            'concentracion'       => 'required|string|max:255',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nombre_generico.required'     => 'El nombre genérico es obligatorio',
            'via_administracion.required'  => 'La vía de administración es obligatoria',
            'efecto.required'              => 'El efecto es obligatorio',
            'concentracion.required'       => 'La concentración es obligatoria',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errores[] = [
                'fila' => $failure->row(),
                'atributo' => $failure->attribute(),
                'errores' => $failure->errors(),
                'valores' => $failure->values(),
            ];
        }
    }
}