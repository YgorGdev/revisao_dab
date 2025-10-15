<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = $this->service->me($request);

        return ['status' => true, 'message' => Geral::USUARIO_ENCONTRADO, "usuario" => $user];
    }

    /**
     * Cria um novo usuário, atribuindo o tipo padrão (Inquilino = 3).
     *
     * @param UserRequest $request
     * @return array
     */
    public function create(UserRequest $request)
    {
        $DEFAULT_USER_TYPE_ID = 3;

        $request->merge(['tipo_usuario_id' => $DEFAULT_USER_TYPE_ID]);

        $user = $this->service->create($request);

        return ['status' => true, 'message' => Geral::USUARIO_CADASTRADO, "usuario" => $user];
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}