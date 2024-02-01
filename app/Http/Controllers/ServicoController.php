<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicoFormRequest;
use App\Models\servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ServicoController extends Controller
{
    public function store(Request $request)
    {
        $servicos = servico::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'duracao' => $request->duracao,
            'preco' => $request->preco,
        ]);

        return response()->json([
            "succes" => true,
            "message" => "Serviço Cadastrado com sucesso",
            "data" => $servicos
        ], 200);
    }

    public function retornarTodos()
    {
        $servicos = servico::all();
        return response()->json([
            'status' => true,
            'data' => $servicos
        ]);
    }

    public function pesquisarPorId($id)
    {
        $servicos = servico::find($id);

        if ($servicos == null) {
            return response()->json([
                'status' => false,
                'message' => "serviço não encontrado"
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $servicos
        ]);
    }

    public function pesquisarPorNome(Request $request)
    {
        $servicos = Servico::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (count($servicos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $servicos
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }


    public function pesquisarPorDescricao(Request $request)
    {
        $servicos = servico::where('descricao', 'like', '%' . $request->descricao . '%')->get();

        if (count($servicos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $servicos
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function update(Request $request)
    {
        $servicos = servico::find($request->id);

        if (!isset($servicos)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        if (isset($request->nome)) {
            $servicos->nome = $request->nome;
        }
        if (isset($request->descricao)) {
            $servicos->descricao = $request->descricao;
        }
        if (isset($request->duracao)) {
            $servicos->duracao = $request->duracao;
        }
        if (isset($request->preco)) {
            $servicos->preco = $request->preco;
        }

        $servicos->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }

    public function excluir($id)
    {
        $servicos = servico::find($id);

        if (!isset($servicos)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encotrado"
            ]);
        }

        $servicos->delete();

        return response()->json([
            'status' => true,
            'message' => "Cadastro excluido com sucesso"
        ]);
    }
}