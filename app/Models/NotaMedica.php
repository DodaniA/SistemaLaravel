<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaMedica extends Model
{
    //
    protected $table = 'notas_medicas';

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }

    
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    

}
