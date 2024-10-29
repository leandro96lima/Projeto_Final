<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Jobs\SendTypeChangeTokenEmail;
use App\Mail\TokenMail;
use App\Models\Technician;
use App\Models\TypeChangeRequest;
use App\Models\User;
use App\Notifications\TypeChangeRequestNotification;
use App\Repositories\TypeChangeRequestRepository;
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
    protected TypeChangeRequestRepository $typeChangeRequestRepository;

    public function __construct(TypeChangeRequestRepository $typeChangeRequestRepository)
    {
        $this->typeChangeRequestRepository = $typeChangeRequestRepository;
    }

    public function index()
    {
        //
        return view('users.index');
    }


    public function edit(Request $request): View
    {
        // Obtém o usuário logado
        $user = $request->user();

        // Verifica se o tipo de usuário é 'Technician' e carrega a instância correta
        if ($user->type === 'Technician') {
            $user = Technician::find($user->id);
        }

        return view('profile.edit', [
            'user' => $user,
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

    public function requestTypeChangeToken(Request $request, TypeChangeRequestRepository $typeChangeRequestRepository)
    {
        try {
            Log::info('Iniciando validação dos campos.');

            // Valida os campos
            $request->validate([
                'requested_type' => 'required|string|in:User,Admin,Technician',
                'request_reason' => 'required|string|max:255',
            ]);

            $user = auth()->user();
            Log::info('Usuário autenticado.', ['user_id' => $user->id, 'user_name' => $user->name]);

            // Checa se há solicitação pendente
            if ($typeChangeRequestRepository->hasPendingRequest($user)) {
                return back()->with('status', 'Você já possui uma solicitação pendente.');
            }

            // Verifica se a mudança de tipo é permitida
            if (!$typeChangeRequestRepository->canRequestAdminType($user)) {
                return back()->with('status', 'Não é possível mudar de tipo no momento devido à contagem de administradores.');
            }

            // Cria a solicitação de mudança de tipo e envia notificação
            $typeChangeRequest = $typeChangeRequestRepository->processTypeChangeRequest(
                $user,
                $request->input('requested_type'),
                $request->input('request_reason')
            );

            return back()->with('status', 'Sua solicitação foi enviada e está aguardando aprovação.');
        } catch (Exception $e) {
            Log::error('Erro ao processar a solicitação de mudança de tipo.', [
                'error_message' => $e->getMessage(),
                'user_id' => auth()->check() ? auth()->user()->id : 'não autenticado',
            ]);

            return back()->withErrors(['error' => 'Ocorreu um erro ao processar sua solicitação.']);
        }
    }
}
