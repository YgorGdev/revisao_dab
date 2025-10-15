<?php

namespace App\Http\Requests;

use App\Rules\UsuarioRule;
use Illuminate\Foundation\Http\FormRequest;

class CondominioRequest extends FormRequest
{
    protected $rule;

    public function __construct(UsuarioRule $rule) {
        $this->rule = $rule;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Autoriza a requisição apenas se o usuário for um 'Proprietário'
        $isProprietario = $this->rule->isProprietario();

        return $isProprietario;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Regras de validação conforme solicitado:
            'condominio' => 'sometimes|string',
            'endereco' => 'required|string'
        ];
    }

    /**
     * Define mensagens de erro customizadas.
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser uma string.'
        ];
    }
}
