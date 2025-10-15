<?php

namespace App\Http\Controllers;

use App\Constants\Geral;
use App\Services\BlocoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlocoController extends Controller
{
    protected $service;

    public function __construct(BlocoService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $bloco = $this->service->create($request);
        return ['status' => true, 'message' => Geral::BLOCO_CADASTRADO, "bloco" => $bloco];
    }

    /**
     * Lista blocos. Admin vê todos, outros veem os relacionados.
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        
        // Adicionando uma verificação de segurança, embora o middleware deva proteger
        if (!$user) {
            return ['status' => false, 'message' => 'Usuário não autenticado.', "blocos" => []];
        }
        
        if ($user->tipo_usuario_id === 1) { // Admin
             // Chama o método para listar TODOS os blocos
             $blocos = $this->service->getAllBlocos();
             $message = 'Lista completa de blocos.';
        } else { // Proprietário/Inquilino
             // Chama o método para listar blocos RELACIONADOS ao ID do usuário
             $blocos = $this->service->getRelatedBlocos($user->id); 
             $message = 'Blocos relacionados.';
        }

        return ['status' => true, 'message' => $message, "blocos" => $blocos];
    }
}