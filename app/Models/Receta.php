<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Receta extends Model
{
    //
    use SoftDeletes;
    protected $table = 'recetas';
    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'cita_id',
        'indicaciones',
    ];
    protected $dates = ['deleted_at'];


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
     public function medicamentos()
    {
        return $this->hasMany(RecetaMedicamento::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id');
    }
}
