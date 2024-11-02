<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @param string $types
     * @return mixed
     */

    public function handle(Request $request, Closure $next, string $types): Response
    {
        if (Auth::check()) {
            $user = Auth::user()->fresh(); // Recarrega o usuário autenticado

            // Verifica se a rota atual é a do 'store' do EquipmentController
            if ($request->is('equipments') && $request->isMethod('post') && $request->input('from_partial') === 'user-create-equipment') {
                // Permite que qualquer usuário que acesse esta rota continue
                return $next($request);
            }

            // Se não for a rota de store, continua com a lógica original para tipos de usuários
            if ($user->getType()) {
                $userType = strtolower(trim($user->getType())); // Defina o tipo de usuário
                $expectedTypes = array_map('strtolower', array_map('trim', explode(',', $types))); // Suporte para múltiplos tipos

                // Verifica se o tipo de usuário está na lista de tipos permitidos
                if (in_array($userType, $expectedTypes)) {
                    return $next($request);
                } else {
                    Log::warning('Tipo de usuário inválido.', [
                        'user_id' => $user->id,
                        'user_type' => $userType,
                        'expected_types' => $expectedTypes,
                    ]);
                }
            } else {
                Log::warning('Tipo de usuário não definido.', [
                    'user_id' => $user->id,
                ]);
            }
        } else {
            Log::warning('Usuário não autenticado.');
        }

        Log::warning('Acesso negado ao usuário.', [
            'user_id' => Auth::check() ? Auth::user()->id : 'não autenticado',
            'user_type' => Auth::check() ? Auth::user()->getType() : 'não autenticado',
            'requested_route' => $request->url(),
            'expected_types' => $types,
        ]);

        return redirect()->to(url()->previous())->with('error', 'Você não tem permissão para acessar esta área.');

    }
}
