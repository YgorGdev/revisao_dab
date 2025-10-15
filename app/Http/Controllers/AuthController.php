<?php

namespace App\Http\Controllers;

use App\Constants\Geral; 
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Realiza o login do usuário e gera o token de acesso.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');


        if (!Auth::attempt($credentials)) {

            return response()->json([
                'status' => false,
                'message' => Geral::USUARIO_INCORRETO,
            ], 401); 
        }

        $user = Auth::user();

      

        return response()->json([
            'status' => true,
            'message' => Geral::USUARIO_LOGADO,
            'usuario' => $user,
        ], 200);
    }

    /**
     *
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {

        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return ['status' => true, 'message' => Geral::USUARIO_DESLOGADO];
    }
}