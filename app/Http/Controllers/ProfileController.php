<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Mail\TokenMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        //
        return view('users.index');
    }


    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Preencher os dados do usuário com os campos validados
        $user = $request->user();
        $user->fill($request->validated());

        // Verificar se o email foi alterado, caso tenha sido, invalidar a verificação anterior
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Verificar se o campo 'type' está presente e precisa ser atualizado
        if ($request->has('type')) {
            $newType = $request->input('type');
            $token = $request->input('token');

            // Verificar se o token é válido
            if (session('type_change_token') && $token === session('type_change_token')) {
                if ($user->type !== $newType) {
                    $user->type = $newType;

                    // Dependendo do tipo, criar a instância correta
                    switch ($newType) {
                        case 'Admin':
                            app(AdminController::class)->store($user);
                            break;

                        case 'Technician':
                            app(TechnicianController::class)->store($user);
                            break;

                        default:
                            // Se não for Admin nem Technician, não faça nada.
                            break;
                    }
                }
            } else {
                return Redirect::route('profile.edit')->withErrors(['token' => 'Invalid token.']);
            }
        }

        // Salvar as alterações no banco de dados
        $user->save();

        // Redirecionar de volta para a página de edição do perfil com uma mensagem de sucesso
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function sendTypeChangeToken(Request $request)
    {
        // Gerar um token aleatório
        $token = Str::random(6); // Você pode ajustar o tamanho do token conforme necessário

        // Enviar o token por email
        Mail::to('hernani.arriscado@gmail.com')->send(new TokenMail($token));

        // Armazenar o token na sessão (ou você pode armazená-lo no banco de dados)
        session(['type_change_token' => $token]);

        // Redirecionar de volta com uma mensagem de sucesso
        return back()->with('status', 'Token sent to your email.');
    }
}
