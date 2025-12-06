<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Especialidad;
use App\Models\GrupoSanguineo;

class ApiController extends Controller
{
    // GET /api/medicamentos
    public function listaDeMedicamentos()
    {
        $medicamentos = Medicamento::with(['via', 'efecto'])
            ->select('id', 'nombre_generico', 'concentracion', 'via_id', 'efecto_id')
            ->get();

        return response()->json($medicamentos);
    }

    // GET /api/tipos-sangre
    public function tiposdesangre()
    {
        $tipos = GrupoSanguineo::select('id', 'tipo')->get();

        return response()->json($tipos);
    }

    // GET /api/especialidades
    public function especialidades()
    {
        $especialidades = Especialidad::select('id', 'nombre')->get();

        return response()->json($especialidades);
    }
}
