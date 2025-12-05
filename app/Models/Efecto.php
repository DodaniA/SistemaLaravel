<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Efecto extends Model
{
    protected $table = 'efectos';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
    ];

    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
