<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoSanguineo extends Model
{
    //
    protected $table = 'grupos_sanguineos';
    protected $fillable = [
        'tipo',
    ];
}
