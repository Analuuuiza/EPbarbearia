<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientesFormRequest;
use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ClienteController extends Controller
{
    public function store(ClientesFormRequest $request)
    {
        $clientes = clientes::create([
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

        ]);

        return response()->json([
            "success" => true,
            "message" => "Cliente Cadastrado com sucesso",
            "data" => $clientes
        ], 200);
    }

    public function retornarTodos()
    {
        $clientes = clientes::all();
        return response()->json([
            'status' => true,
            'data' => $clientes
        ]);
    }

    public function pesquisarPorId($id)
    {
        $clientes = clientes::find($id);

        if ($clientes == null) {
            return response()->json([
                'status' => false,
                'message' => "cliente não encontrado"
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $clientes
        ]);
    }

    public function pesquisarPorNome(Request $request)
    {
        $clientes = clientes::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (count($clientes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $clientes
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function pesquisarPorCpf(Request $request)
    {
        $clientes = clientes::where('cpf', 'like', '%' . $request->cpf . '%')->get();

        if (count($clientes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $clientes
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorCelular(Request $request)
    {
        $clientes = clientes::where('celular', 'like', '%' . $request->celular . '%')->get();

        if (count($clientes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $clientes
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function pesquisarPorEmail(Request $request)
    {
        $clientes = clientes::where('email', 'like', '%' . $request->email . '%')->get();

        if (count($clientes) > 0) {
            return response()->json([
                'status' => true,
                'data' => $clientes
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function update(Request $request)
    {
        $cliente = clientes::find($request->id);

        if (!isset($cliente)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        if (isset($request->nome)) {
            $cliente->nome = $request->nome;
        }
        if (isset($request->celular)) {
            $cliente->celular = $request->celular;
        }
        if (isset($request->email)) {
            $cliente->email = $request->email;
        }
        if (isset($request->cpf)) {
            $cliente->cpf = $request->cpf;
        }
        if (isset($request->dataNascimento)) {
            $cliente->dataNascimento = $request->dataNascimento;
        }
        if (isset($request->cidade)) {
            $cliente->cidade = $request->cidade;
        }
        if (isset($request->estado)) {
            $cliente->estado = $request->estado;
        }
        if (isset($request->pais)) {
            $cliente->pais = $request->pais;
        }
        if (isset($request->rua)) {
            $cliente->rua = $request->rua;
        }
        if (isset($request->numero)) {
            $cliente->numero = $request->numero;
        }
        if (isset($request->bairro)) {
            $cliente->bairro = $request->bairro;
        }
        if (isset($request->cep)) {
            $cliente->cep = $request->cep;
        }
        if (isset($request->complemento)) {
            $cliente->complemento = $request->complemento;
        }
        if (isset($request->senha)) {
            $cliente->senha = $request->senha;
        }

        $cliente->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }


    public function excluir($id)
    {
        $cliente = clientes::find($id);

        if (!isset($cliente)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encotrado"
            ]);
        }

        $cliente->delete();

        return response()->json([
            'status' => true,
            'message' => "Cadastro excluido com sucesso"
        ]);
    }

    public function esqueciSenha(Request $request)
    {
        $cliente = clientes::where('cpf', '=', $request->cpf)->first();


        if (!isset($cliente)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        $cliente->senha = Hash::make($cliente->cpf);

        $cliente->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }

    public function esqueciSenhaCliente(Request $request)
    {
        $cliente = clientes::where('cpf', $request->cpf)->where('email', $request->email)->first();

        if (isset($cliente)) {
            $cliente->senha = Hash::make($cliente->senha);
            $cliente->update();
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
