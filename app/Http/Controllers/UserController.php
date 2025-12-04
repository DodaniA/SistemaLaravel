<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Doctor;

class UserController extends Controller
{
    public function completo($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        if ($user->role === 'Paciente') {
            $paciente = Paciente::where('user_id', $user->id)->first();

            if ($paciente) {
                return response()->json(['complete' => true]);
            } else {
                return response()->json(['complete' => false]);
            }
        } elseif ($user->role === 'Medico') {
            $medico = Doctor::where('user_id', $user->id)->first();
            if ($medico) {
                return response()->json(['complete' => true]);
            } else {
                return response()->json(['complete' => false]);
            }
        }
        return response()->json(['complete' => true]);
    }
}
