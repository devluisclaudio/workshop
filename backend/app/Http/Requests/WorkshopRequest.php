<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'grupo_id' => 'required',
            'nome' => 'required',
            'sexo' => 'required',
            'idade' => 'required',
            'estado_civil_id' => 'required',
            'celular' => 'required',
            'email' => 'required',
            'nome_lider_gr' => 'required'
        ];
    }
}
