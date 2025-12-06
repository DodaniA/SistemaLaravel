<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Doctor extends Model
{
    use SoftDeletes;
    protected $table = 'doctores';
    protected $fillable = [
        'user_id',
        'especialidad_id',
        'descripcion',
        'cedula_profesional',
    ];
    protected $dates = ['deleted_at'];
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
