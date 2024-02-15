<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class admFormRequest extends FormRequest
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
            'name' => 'required|max:120',
            'email' => 'required|max:120|email|unique:clientes,email',
            'cpf' => 'required|max:11|min:11|unique:clientes,cpf',
            'password' => 'required',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo name é obrigatorio',
            'name.max' => 'o campo name deve conter no maximo 120 caracteres',
            'email.max' => 'Email deve conter no maximo 120 caracteres',
            'email.required' => 'Email obrigatorio',
            'email.unique' => 'Email ja cadastrado no sistema',
            'email.email' => 'Formato invalido',
            'cpf.required' => 'Cpf obrigatorio',
            'cpf.max' => 'o campo CPF deve conter no maximo 11 caracteres',
            'cpf.min' => 'o campo CPF dever conter no minimo 11 caracteres',
            'cpf.unique' => 'CPF ja cadastrado no sistema',
            'password.required' => 'Senha obrigatorio',



        ];
    }
}
