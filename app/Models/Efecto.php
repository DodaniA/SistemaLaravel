<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Efecto extends Model
{
    protected $table = 'efectos';

    protected $fillable = [
        'nombre',
    ];
}
