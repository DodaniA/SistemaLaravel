<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Medicamento extends Model
{
    use SoftDeletes;
    
    protected $table = 'medicamentos';
    protected $dates = ['deleted_at']; 
    protected $fillable = [
        'nombre_generico',
        'via_id',
        'efecto_id',
        'concentracion',
    ];
    
    public function via()
    {
        return $this->belongsTo(ViaAdministracion::class, 'via_id');
    }
    public function efecto()
    {
        return $this->belongsTo(Efecto::class, 'efecto_id');
    }
}
