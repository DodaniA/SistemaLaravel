<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'citas';
    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha_hora',
        'estado',
        'motivo',
        'clima',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }
}
