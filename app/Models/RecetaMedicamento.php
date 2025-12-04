<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecetaMedicamento extends Model
{
    protected $table = 'receta_medicamentos';
    protected $fillable = [
        'receta_id',
        'medicamento_id',
        'dosis',
        'frecuencia',
        'duracion',
        'instrucciones',
    ];


    public function receta()
    {
        return $this->belongsTo(Receta::class, 'receta_id');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
