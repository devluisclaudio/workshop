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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'grupo_id.required' => 'Selecionar uma palestra é obrigatório',
            'nome.required' => 'Nome é obrigatório',
            'sexo.required' => 'Sexo é obrigatório',
            'idade.required' => 'Idade é obrigatório',
            'estado_civil_id.required' => 'Estado civil é obrigatório',
            'celular.required' => 'Celular é obrigatório',
            'email.required' => 'Email é obrigatório',
            'nome_lider_gr.required' => 'Lider de GR é obrigatório',
        ];
    }
}
