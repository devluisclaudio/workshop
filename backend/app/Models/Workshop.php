<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'workshops';

    protected $fillable = [
        'grupo_id',
        'nome',
        'sexo',
        'idade',
        'estado_civil_id', 
        'celular', 
        'nome_lider_gr',
        'email'
    ];
}
