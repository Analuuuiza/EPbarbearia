<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfissionalFormRequest;
use App\Models\profissional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ProfissionalController extends Controller
{
    public function store(ProfissionalFormRequest $request)
    {
        $profissional = profissional::create([
            'nome' => $request->nome,
            'celular' => $request->celular,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'dataNascimento' => $request->dataNascimento,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'pais' => $request->pais,
            'rua' => $request->rua,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cep' => $request->cep,
            'complemento' => $request->complemento,
            'senha' => Hash::make($request->senha),
            'salario' => $request->salario,

        ]);

        return response()->json([
            "succes" => true,
            "message" => "Profissional Cadastrado com sucesso",
            "data" => $profissional
        ], 200);
    }

    public function retornarTodos()
    {
        $profissional = profissional::all();
        return response()->json([
            'status' => true,
            'data' => $profissional
        ]);
    }

    public function pesquisarPorId($id)
    {
        $profissional = profissional::find($id);

        if ($profissional == null) {
            return response()->json([
                'status' => false,
                'message' => "profissional não encontrado"
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $profissional
        ]);
    }
    public function pesquisarPorNome(Request $request)
    {
        $profissional = profissional::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (count($profissional) > 0) {
            return response()->json([
                'status' => true,
                'data' => $profissional
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function pesquisarPorCpf(Request $request)
    {
        $profissional = profissional::where('cpf', 'like', '%' . $request->cpf . '%')->get();

        if (count($profissional) > 0) {
            return response()->json([
                'status' => true,
                'data' => $profissional
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorCelular(Request $request)
    {
        $profissional = profissional::where('celular', 'like', '%' . $request->celular . '%')->get();

        if (count($profissional) > 0) {
            return response()->json([
                'status' => true,
                'data' => $profissional
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function pesquisarPorEmail(Request $request)
    {
        $profissional = profissional::where('email', 'like', '%' . $request->email . '%')->get();

        if (count($profissional) > 0) {
            return response()->json([
                'status' => true,
                'data' => $profissional
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function update(Request $request)
    {
        $profissional = profissional::find($request->id);

        if (!isset($profissional)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        if (isset($request->nome)) {
            $profissional->nome = $request->nome;
        }
        if (isset($request->celular)) {
            $profissional->celular = $request->celular;
        }
        if (isset($request->email)) {
            $profissional->email = $request->email;
        }
        if (isset($request->cpf)) {
            $profissional->cpf = $request->cpf;
        }
        if (isset($request->dataNascimento)) {
            $profissional->dataNascimento = $request->dataNascimento;
        }
        if (isset($request->cidade)) {
            $profissional->cidade = $request->cidade;
        }
        if (isset($request->estado)) {
            $profissional->estado = $request->estado;
        }
        if (isset($request->pais)) {
            $profissional->pais = $request->pais;
        }
        if (isset($request->rua)) {
            $profissional->rua = $request->rua;
        }
        if (isset($request->numero)) {
            $profissional->numero = $request->numero;
        }
        if (isset($request->bairro)) {
            $profissional->bairro = $request->bairro;
        }
        if (isset($request->cep)) {
            $profissional->cep = $request->cep;
        }
        if (isset($request->complemento)) {
            $profissional->complemento = $request->complemento;
        }
        if (isset($request->senha)) {
            $profissional->senha = $request->senha;
        }
        if (isset($request->salario)) {
            $profissional->salario = $request->salario;
        }
        $profissional->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }


    public function excluir($id)
    {
        $profissional = profissional::find($id);

        if (!isset($profissional)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encotrado"
            ]);
        }

        $profissional->delete();

        return response()->json([
            'status' => true,
            'message' => "Cadastro excluido com sucesso"
        ]);
    }

    public function esqueciSenhaProfissional(Request $request)
    {
        $profissionals = profissional::where('cpf', '=', $request->cpf)->where('email', '=', $request->email)->first();

        if (isset($profissionals)) {
            $profissionals->senha = Hash::make($profissionals->senha);
            $profissionals->update();
            return response()->json([
                'status' => true,
                'message' => 'senha redefinida.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'não foi possivel alterar a senha'
        ]);
    }
}
