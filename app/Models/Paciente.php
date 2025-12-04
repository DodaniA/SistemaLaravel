<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Paciente extends Model
{
    //
    use SoftDeletes;
    protected $table = 'pacientes';
    protected $fillable = [
        'user_id',
        'grupo_sanguineo_id',
        'diagnosticos_previos',
        'alergias',
    ];

    protected $dates = ['deleted_at'];
    public function grupoSanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'grupo_sanguineo_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
