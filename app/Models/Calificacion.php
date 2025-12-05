<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Calificacion extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'calificaciones';
    
    protected $fillable = [
        'doctor_id',
        'paciente_id',
        'cita_id',
        'calificacion',
        'comentario',
    ];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

 
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }


    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
 