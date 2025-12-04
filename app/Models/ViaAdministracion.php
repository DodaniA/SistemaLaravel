<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViaAdministracion extends Model
{
    protected $table = 'vias_administracion';
    protected $fillable = [
        'nombre',
    ];
}
