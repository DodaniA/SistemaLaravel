<?php

namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Cita;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'cedula_profesional' => 'required|unique:doctores,cedula_profesional',
            'descripcion' => 'nullable|string|max:255', 
        ]);
        Doctor::create([
            'user_id' => auth()->user()->id,  
            'especialidad_id' => $request->especialidad_id,
            'cedula_profesional' => $request->cedula_profesional,
            'descripcion' => $request->descripcion, 
        ]);
        return redirect()->route('dashboard')->with('success', 'Información guardada correctamente.');
    }
    public function atender($citaId)
    {
        $doctorId = Doctor::where('user_id', auth()->id())->first()?->id;
        if (!$doctorId) {
            abort(403, 'No tienes permisos para acceder a esta página.');
        }
        $cita = Cita::where('id', $citaId)
            ->where('doctor_id', $doctorId)
            ->firstOrFail();
        return view('atender', ['citaId' => $citaId]);
    }


}
