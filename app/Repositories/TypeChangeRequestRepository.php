<?php

namespace App\Repositories;

use App\Http\Controllers\AdminController;
use App\Models\TypeChangeRequest;
use App\Models\User;
use App\Notifications\TypeChangeRequestNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

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
            app(AdminController::class)->sendTypeChangeToken($user->id, 'Admin');
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
}
