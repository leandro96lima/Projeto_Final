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

    public function handle(Request $request, Closure $next, string $types): mixed
    {
        if (Auth::check()) {
            $user = Auth::user()->fresh(); // Recarrega o usuário autenticado

            // Use o getter para acessar o tipo de usuário
            if ($user->getType()) {
                Log::info('Tipo de usuário inicializado:', [
                    'user_id' => $user->id,
                    'user_type' => $user->getType(),
                ]);

                $userType = strtolower(trim($user->getType()));
                $expectedTypes = array_map('strtolower', array_map('trim', explode(',', $types))); // Suporte para múltiplos tipos

                Log::info('Verificando tipo de usuário:', [
                    'user_type' => $userType,
                    'expected_types' => $expectedTypes,
                ]);

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

        return redirect('/dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
    }
}
