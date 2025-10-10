<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table='materias';
    protected $fillable=[
        'id_profesor',
        'nombre',
    ];
    public $timestamps = false;
    public function profesor(){
        return $this->belongsTo(User::class,'id_profesor');
    }
    public function inscripcions(){
        return $this->hasMany(Inscripcion::class,'id_materia');
    }
}
