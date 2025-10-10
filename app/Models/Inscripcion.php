<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table='inscripciones';
    protected $fillable=[
        'id_alumno',
        'id_materia',
    ];
    public $timestamps = false;
    public function alumno(){
        return $this->belongsTo(User::class,'id_alumno');
    }
    public function materia(){
        return $this->belongsTo(Materia::class,'id_materia');
    }
    public function calificacions(){
        return $this->hasMany(Calificacion::class,'id_inscripcion');
    }
}
