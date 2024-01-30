<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use Illuminate\Http\Request;

class FormaDePagamentoController extends Controller
{
    public function store(Request $request)
    {
        $pagamentos = Pagamento::create([
            'nome' => $request->nome,
            'taxa' => $request->taxa,
            'status' => $request->status,
           
        ]);

        return response()->json([
            "succes" => true,
            "message" => "forma de pagamento Cadastrado com sucesso",
            "data" => $pagamentos
        ], 200);
    }

    public function excluir($id)
    {
        $pagamentos = Pagamento::find($id);

        if (!isset($pagamentos)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encotrado"
            ]);
        }

        $pagamentos->delete();

        return response()->json([
            'status' => true,
            'message' => "Cadastro excluido com sucesso"
        ]);
    }
    public function update(Request $request)
    {
        $pagamentos = Pagamento::find($request->id);

        if (!isset($pagamentos)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        if (isset($request->nome)) {
            $pagamentos->nome = $request->nome;
        }
        if (isset($request->taxa)) {
            $pagamentos->taxa = $request->taxa;
        }
        if (isset($request->status)) {
            $pagamentos->status = $request->status;
        }

        $pagamentos->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }

    public function pesquisarPorNome(Request $request)
    {
        $pagamentos = Pagamento::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (count($pagamentos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $pagamentos
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorTaxa(Request $request)
    {
        $pagamentos = Pagamento::where('taxa', 'like', '%' . $request->taxa . '%')->get();

        if (count($pagamentos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $pagamentos
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }

    public function pesquisarPorStatus(Request $request)
    {
        $pagamentos = Pagamento::where('status', 'like', '%' . $request->status . '%')->get();

        if (count($pagamentos) > 0) {
            return response()->json([
                'status' => true,
                'data' => $pagamentos
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'Não há resultados para a pesquisa.'
        ]);
    }
}
