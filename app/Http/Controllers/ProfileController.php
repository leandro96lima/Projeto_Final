<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Jobs\SendTypeChangeTokenEmail;
use App\Mail\TokenMail;
use App\Models\TypeChangeRequest;
use App\Models\User;
use App\Notifications\TypeChangeRequestNotification;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
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
        $user = $request->user();
        $validatedData = $request->validated();
        $newType = $request->input('type');
        $token = $request->input('token');

        // Guard clause: Verifica o token de segurança
        if ($newType && (!$token || $token !== session('type_change_token'))) {
            return Redirect::route('profile.edit')->withErrors(['token' => 'Invalid token.']);
        }

        // Preenche os dados validados e invalida o endereço eletrónico verificado se foi alterado
        $user->fill($validatedData);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Verifica se o 'type' foi alterado e atualiza a instância do tipo de utilizador
        if ($newType && $user->type !== $newType) {
            $this->updateUserTypeInstance($user, $newType);
        }

        // Salvar as alterações no banco de dados
        $user->save();

        // Redirecionar de volta para a página de edição do perfil com uma mensagem de sucesso
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

// Método auxiliar para gerenciar a instância do tipo de usuário
    private function updateUserTypeInstance(User $user, string $newType): void
    {
        $controllerMap = [
            'Admin' => AdminController::class,
            'Technician' => TechnicianController::class,
        ];

        // Remove a instância do tipo anterior, se existir
        foreach ($controllerMap as $type => $controller) {
            if ($user->{$type}()->exists()) {
                $user->{$type}()->delete();
            }
        }

        // Cria a nova instância, se necessário
        if ($newType !== 'User' && isset($controllerMap[$newType])) {
            app($controllerMap[$newType])->store($user);
        }
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

    public function requestTypeChangeToken(Request $request)
    {
        // Validação dos campos
        try {
            Log::info('Iniciando validação dos campos.');

            $request->validate([
                'requested_type' => 'required|string|in:User,Admin,Technician', // O campo requested_type é obrigatório e deve ser 'User', 'Admin' ou 'Technician'
                'request_reason' => 'required|string|max:255', // O campo request_reason é obrigatório e deve ser uma ‘string’
            ]);

            Log::info('Validação concluída com sucesso.', [
                'requested_type' => $request->input('requested_type'),
                'request_reason' => $request->input('request_reason'),
            ]);

            // Obtém o utilizador logado
            $user = auth()->user();
            Log::info('Usuário autenticado.', [
                'user_id' => $user->id,
                'user_name' => $user->name,
            ]);

            // Valida se o utilizador já tem uma solicitação pendente
            if (TypeChangeRequest::where('user_id', $user->id)->where('status', 'pending')->exists()) {
                Log::warning('Usuário já possui uma solicitação pendente.', [
                    'user_id' => $user->id,
                ]);
                return back()->with('status', 'Você já possui uma solicitação pendente.');
            }

            // Cria a solicitação
            Log::info('Criando solicitação de mudança de tipo.', [
                'user_id' => $user->id,
                'requested_type' => $request->input('requested_type'),
                'reason' => $request->input('request_reason'),
            ]);

// Cria a solicitação
            $typeChangeRequest = TypeChangeRequest::create([
                'user_id' => $user->id,
                'requested_type' => $request->input('requested_type'),
                'reason' => $request->input('request_reason'),
            ]);

            Log::info('Solicitação de mudança de tipo criada com sucesso.', [
                'user_id' => $user->id,
                'requested_type' => $request->input('requested_type'),
            ]);

            // Notifica o administrador (opcional: pode ser via endereço eletrónico)
            Notification::route('mail', 'admin@gmail.com')->notify(new TypeChangeRequestNotification($typeChangeRequest));
            Log::info('Notificação enviada ao administrador.', [
                'admin_email' => 'admin@gmail.com',
            ]);

            return back()->with('status', 'Sua solicitação foi enviada e está aguardando aprovação.');
        } catch (Exception $e) {
            // ‘Log’ de erro caso ocorra alguma exceção
            Log::error('Erro ao processar a solicitação de mudança de tipo.', [
                'error_message' => $e->getMessage(),
                'user_id' => auth()->check() ? auth()->user()->id : 'não autenticado',
                'requested_type' => $request->input('requested_type', 'não fornecido'),
                'request_reason' => $request->input('request_reason', 'não fornecido'),
            ]);

            return back()->withErrors(['error' => 'Ocorreu um erro ao processar sua solicitação.']);
        }
    }
}
