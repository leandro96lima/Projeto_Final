<?php

namespace App\Repositories;

use App\Http\Controllers\AdminController;
use App\Mail\TokenMail;
use App\Models\TypeChangeRequest;
use App\Models\User;
use App\Notifications\TypeChangeRequestNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class TypeChangeRequestRepository
{
    // Verifica se o usuário já possui uma solicitação pendente
    public function hasPendingRequest($user): bool
    {
        if (TypeChangeRequest::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            Log::warning('Usuário já possui uma solicitação pendente.', ['user_id' => $user->id]);
            return true;
        }
        return false;
    }

    // Verifica se é possível solicitar a mudança para Admin
    public function canRequestAdminType($user, $requestedType): bool
    {
        $adminCount = User::where('type', 'Admin')->count();

        // Se não houver administradores e o usuário deseja se tornar Admin
        if ($adminCount === 0 && $requestedType === 'Admin') {
            Log::warning('Sem administradores. Enviando notificação para o helpdesk.', ['user_id' => $user->id]);
            $this->sendTypeChangeToken($user->id, 'Admin');
            return true; // Permite que o usuário solicite mudança para Admin
        }

        // Se há apenas um Admin e o usuário é esse único Admin tentando mudar para outro tipo
        if ($adminCount === 1 && $user->type === 'Admin' && $requestedType !== 'Admin') {
            Log::warning('Mudança de tipo negada: o usuário é o único administrador restante.', ['user_id' => $user->id]);
            return false; // Bloqueia a mudança se ele é o único Admin e quer mudar para outro tipo
        }

        return true; // Permite a mudança em outras condições
    }

    // Processa a solicitação de mudança de tipo e notifica administradores
    public function processTypeChangeRequest($user, $requestedType, $reason)
    {
        $typeChangeRequest = $this->createTypeChangeRequest($user, $requestedType, $reason);
        $this->notifyAdmins($typeChangeRequest);
        return $typeChangeRequest;
    }

    // Cria a solicitação de mudança de tipo
    private function createTypeChangeRequest($user, $requestedType, $reason)
    {
        $typeChangeRequest = TypeChangeRequest::create([
            'user_id' => $user->id,
            'requested_type' => $requestedType,
            'reason' => $reason,
        ]);

        Log::info('Solicitação de mudança de tipo criada com sucesso.', [
            'user_id' => $user->id,
            'requested_type' => $requestedType,
        ]);

        return $typeChangeRequest;
    }

    // Notifica todos os administradores sobre a nova solicitação
    private function notifyAdmins($typeChangeRequest): void
    {
        User::where('type', 'Admin')->each(function ($admin) use ($typeChangeRequest) {
            Notification::route('mail', $admin->email)->notify(new TypeChangeRequestNotification($typeChangeRequest));
            Log::info('Notificação enviada ao administrador.', ['admin_email' => $admin->email]);
        });
    }

    // Atualiza a solicitação como aprovada
    public function approveRequest(TypeChangeRequest $request, $adminId): void
    {
        $request->update([
            'status' => 'approved',
            'processed_by_admin_id' => $adminId,
        ]);

        Log::info('Solicitação aprovada.', ['request_id' => $request->id]);
    }

    // Atualiza a solicitação como rejeitada
    public function rejectRequest(TypeChangeRequest $request, $adminId): void
    {
        $request->update([
            'status' => 'rejected',
            'processed_by_admin_id' => $adminId,
        ]);

        Log::info('Solicitação rejeitada.', ['request_id' => $request->id]);
    }

    // Envia um token de mudança de tipo
    public function sendTypeChangeToken(int $user_id, string $requestedType = null)
    {
        if (Session::has('type_change_token_sent_at') && now()->diffInMinutes(Session::get('type_change_token_sent_at')) < 5) {
            return ['status' => false, 'message' => 'Você deve esperar antes de solicitar um novo token.'];
        }

        $token = Str::random(6);
        $user = User::find($user_id);
        $recipientEmail = ($requestedType === 'Admin' && User::where('type', 'Admin')->count() === 0)
            ? 'helpdesk@example.com'
            : $user->email;

        Mail::to($recipientEmail)->later(now()->addSeconds(10), new TokenMail($token));
        Session::put('type_change_token', $token);
        Session::put('type_change_token_sent_at', now());

        return [
            'status' => true,
            'message' => 'Token enviado para ' . ($recipientEmail === 'helpdesk@example.com' ? 'o e-mail do helpdesk.' : 'o e-mail do usuário.'),
        ];
    }
}
