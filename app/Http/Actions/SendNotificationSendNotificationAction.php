<?php

namespace App\Http\Actions;

use App\DataTransferObjects\SendNotificationToUserDTO;
use App\Models\User;
use App\Services\PorthosNotification\NotificationService;
use Illuminate\Support\Facades\Cache;

class SendNotificationAction
{
    //TODO the user notificition prefrennces shouldn't be an array
    //TODO think for another better way, maybe make it auto using provider ... , it's not checking other types right now
    //TODO this should be sth like this -> $this->service->sendEmailNotification($user->getEmailNotificationRoute());

    public function __construct(private NotificationService $service)
    {
    }

    public function execute(SendNotificationToUserDTO $dto): void
    {
        $user = $this->getUserById($dto->userId);
        $providerType = $this->resolvePreferredNotificationType($user, $dto);

        if ($providerType === 'email') {
            $this->service->sendEmailNotification(
                recipient: $user->email,
                subject: 'email',
                body: $dto->messageContent
            );
        } elseif ($providerType === 'sms') {
            $this->service->sendSmsNotification(
                recipient: $user->email,
                message: $dto->messageContent
            );
        }
    }

    private function getUserById(int $userId): User
    {
        return User::findOrFail($userId);
    }

    private function resolvePreferredNotificationType(User $user, SendNotificationToUserDTO $dto): string
    {
        if ($dto->preferredNotificationType) {
            return $dto->preferredNotificationType;
        }

        $cachedPreferences = Cache::getOrPut("user:{$user->id}:notification_preferences", function () use ($user) {
            return $this->getUserPreference($user);
        });

        return $cachedPreferences[0] ?? $this->getDefaultProviderType();
    }

    private function getUserPreference(User $user): array
    {
        $preferences = $user->preference->notification_preferences;
        Cache::put("user:{$user->id}:notification_preferences", $preferences, now()->addHours(24));
        return $preferences;
    }

    private function getDefaultProviderType(): string
    {
        return config('porthos-notification-service.default_provider_type');
    }
}
