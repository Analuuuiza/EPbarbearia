<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PagamentoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|max:80|min:5',
            'taxa' => 'required|max:80|min:5',
            'status' => 'required|max:80|boolean',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'sucess' => false,
            'error' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatorio',
            'nome.max' => 'o campo nome deve conter no maximo 80 caracteres',
            'nome.min' => 'o campo nome dever conter no minimo 5 caracteres',
            'taxa.required' => 'O campo taxa é obrigatorio',
            'taxa.max' => 'o campo taxa deve conter no maximo 80 caracteres',
            'taxa.min' => 'o campo taxa dever conter no minimo 5 caracteres',
            'status.required' => 'O campo status é obrigatorio',
            'nome.max' => 'o campo nome deve conter no maximo 80 caracteres',

        ];
    }
}
