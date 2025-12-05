<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViaAdministracion extends Model
{
    protected $table = 'vias_administracion';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
