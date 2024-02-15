<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientesFormRequest;
use App\Models\clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class ClienteController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->all();

            $data['password'] = Hash::make($request->password);

            $response= clientes::create($data)->createToken($request->server('HTTP_USER_AGENT'))->plainTextToken;

            return response()->json([
                'status'=> 'success',
                'message'=> "Cliente cadastrado com sucesso",
                'token'=> $response
            ],200);

         } catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=> $th->getMessage()
            ],500);
         }
    }

    public function login(Request $request){
        
        try{

            if(Auth::guard('clientes')->attempt([
                'email'=> $request->email,
                'password'=> $request->password 
            ])) {
                
                $user = Auth::guard('clientes')->user();
                $token = $user->createToken($request->server('HTTP_USER_AGENT', ['clientes']))->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => 'login efetuado com sucesso',
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'credenciais incorretas'
                ]);
            }
        } catch(\Throwable $th){
            return response()->json([
                'status'=> false,
                'message'=> $th->getMessage() 
            ], 500);
        }
    }

    public function verificarUsuarioLogado(){

        return 'logado';
        
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
        $clientes = clientes::where('name', 'like', '%' . $request->name . '%')->get();

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
        if (isset($request->password)) {
            $cliente->password = $request->password;
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

    public function esquecipassword(Request $request)
    {
        $cliente = clientes::where('cpf', '=', $request->cpf)->first();


        if (!isset($cliente)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        $cliente->password = Hash::make($cliente->cpf);

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
            $cliente->password = Hash::make($cliente->password);
            $cliente->update();
            return response()->json([
                'status' => true,
                'message' => 'Senha redefinida.'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'não foi possivel alterar a password'
        ]);
    }
}
