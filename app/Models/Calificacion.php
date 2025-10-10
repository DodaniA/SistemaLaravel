<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table='calificaciones';
    protected $fillable=[
        'id_inscripcion',
        'calificacion',
        'parcial',
    ];
    
    public $timestamps = false;
    public function inscripcion(){
        return $this->belongsTo(Inscripcion::class,'id_inscripcion');
    }
}
