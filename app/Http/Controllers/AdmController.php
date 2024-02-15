<?php

namespace App\Http\Controllers;

use App\Http\Requests\admFormRequest;
use App\Models\Adm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdmController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->all();

            $data['password'] = Hash::make($request->password);

            $response= Adm::create($data)->createToken($request->server('HTTP_USER_AGENT'))->plainTextToken;

            return response()->json([
                'status'=> 'success',
                'message'=> "Adm cadastrado com sucesso",
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

            if(Auth::guard('adms')->attempt([
                'email'=> $request->email,
                'password'=> $request->password 
            ])) {
                
                $user = Auth::guard('adms')->user();
                $token = $user->createToken($request->server('HTTP_USER_AGENT', ['adms']))->plainTextToken;

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
        $adm =Adm::all();
        return response()->json([
            'status' => true,
            'data' => $adm
        ]);
    }

    public function pesquisarPorId($id)
    {
        $adm =Adm::find($id);

        if ($adm == null) {
            return response()->json([
                'status' => false,
                'message' => "adm não encontrado"
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $adm
        ]);
    }
    public function update(Request $request)
    {
        $adm =Adm::find($request->id);

        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encontrado"
            ]);
        }

        if (isset($request->name)) {
            $adm->name = $request->name;
        }
        if (isset($request->email)) {
            $adm->email = $request->email;
        }
        if (isset($request->cpf)) {
            $adm->cpf = $request->cpf;
        }
        if (isset($request->password)) {
            $adm->password = $request->password;
        }

        $adm->update();

        return response()->json([
            'status' => true,
            'message' => "Cadastro atualizado"
        ]);
    }


    public function excluir($id)
    {
        $adm = Adm::find($id);

        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "Cadastro não encotrado"
            ]);
        }

        $adm->delete();

        return response()->json([
            'status' => true,
            'message' => "Cadastro excluido com sucesso"
        ]);
    }

    public function esqueciSenhaAdm(Request $request)
    {
        $adm = Adm::where('cpf', $request->cpf)->where('email', $request->email)->first();

        if (isset($adm)) {
            $adm->senha = Hash::make($adm->senha);
            $adm->update();
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
