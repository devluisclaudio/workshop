<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workshop extends Model
{
    use SoftDeletes;

    public const GRUPOS = [
        ['id' => '1', 'nome' => 'Casais - (até 49 anos)'],
        ['id' => '2', 'nome' => 'Crianças - (4 a 10 anos)'],
        ['id' => '3', 'nome' => 'Adolescentes - (11 a 17 anos)'],
        ['id' => '4', 'nome' => 'Jovens - (18 a 49 anos)'],
        ['id' => '5', 'nome' => 'Master - (Acima de 49 anos)']
    ];

    public const ESTADOSCIVIS = [
        ['id' => '1', 'nome' => 'Solteiro'],
        ['id' => '2', 'nome' => 'Casado'],
        ['id' => '3', 'nome' => 'Divorciado'],
        ['id' => '4', 'nome' => 'Viúvo']
    ];


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

    protected $appends = [ 'estado_civil', 'grupos'];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function estadoCivil(): Attribute
    {
        return Attribute::make(
            get: function () {
                $arr = Workshop::ESTADOSCIVIS;
                foreach ($arr as $a){
                    if($a['id'] == $this->attributes['estado_civil_id'])
                    $nome = $a['nome'];
                }
                return $nome;
            }
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function grupos(): Attribute
    {
        return Attribute::make(
            get: function () {
                $arr = Workshop::GRUPOS;
                foreach ($arr as $a){
                    if($a['id'] == $this->attributes['grupo_id'])
                    $nome = $a['nome'];
                }
                return $nome;
            }
        );
    }
}
