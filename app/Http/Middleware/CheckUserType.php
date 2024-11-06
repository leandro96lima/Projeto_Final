<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string   $types
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $types): Response
    {
        // Se o usuário não estiver autenticado, retorna a resposta de erro
        if (!Auth::check()) {
            return redirect()->to(url()->previous())->with('error', 'Você precisa estar autenticado para acessar esta área.');
        }

        $user = Auth::user()->fresh(); // Recarrega o usuário autenticado

        // Definindo os tipos de usuário esperados com base no termo 'AdminTechnician'
        $typeMapping = [
            'AdminTechnician' => ['Admin', 'Technician'],
        ];

        // Verifica se o tipo recebido é uma chave no mapeamento
        if (array_key_exists($types, $typeMapping)) {
            // Mapeia o termo para os tipos reais
            $expectedTypes = $typeMapping[$types];
        } else {
            // Trata o tipo como um tipo único
            $expectedTypes = [$types];
        }

        // Verifica se o usuário tem um tipo válido
        if ($user->getType()) {
            $userType = strtolower(trim($user->getType())); // Obtém o tipo do usuário

            // Se o tipo de usuário estiver na lista de tipos permitidos, permite o acesso
            if (in_array($userType, array_map('strtolower', $expectedTypes))) {
                return $next($request);
            }
        }

        // Se o tipo de usuário não corresponder, nega o acesso
        return redirect()->to(url()->previous())->with('error', 'Você não tem permissão para acessar esta área.');
    }
}
