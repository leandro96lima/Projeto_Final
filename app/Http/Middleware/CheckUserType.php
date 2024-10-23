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
     * @param string $type
     * @return mixed
     */

    public function handle(Request $request, Closure $next, string $type): mixed
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
                $expectedType = strtolower(trim($type));

                Log::info('Verificando tipo de usuário:', [
                    'user_type' => $userType,
                    'expected_type' => $expectedType,
                ]);

                if ($userType === $expectedType) {
                    return $next($request);
                } else {
                    Log::warning('Tipo de usuário inválido.', [
                        'user_id' => $user->id,
                        'user_type' => $userType,
                        'expected_type' => $expectedType,
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
            'user_type' => Auth::user()->getType(),
            'requested_route' => $request->url(),
            'expected_type' => $type,
        ]);

        return redirect('/dashboard')->with('error', 'Você não tem permissão para acessar esta área.');
    }
}
