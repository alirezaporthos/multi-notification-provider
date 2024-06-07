<?php

namespace App\Http\Actions;

use App\DataTransferObjects\SendNotificationToUserDTO;
use App\Models\User;
use App\Services\PorthosNotification\NotificationService;

class SendNotificationAction
{
    //TODO you can abstract this service
    public function __construct(private NotificationService $service)
    {
    }

    public function execute(SendNotificationToUserDTO $dto)
    {
        $user = User::findOrFail($dto->userId);

        if (!is_null($dto->preferredNotificationType)) {
            //TODO think for another better way, maybe make it auto using provider ... , it's not checking other types right now

            //TODO the user notificition prefrennces shouldn't be an array
            $userPrefrence = $user->prefrence;
            $providerType = $userPrefrence->notification_prefrences ?
                $userPrefrence->notification_prefrences[0] :
                config('porthos-notification-service.default_provider_type');

            if ($providerType === 'email') {
                //TODO this should be sth like this -> $this->service->sendEmailNotification($user->getEmailNotificationRoute());
                return $this->service->sendEmailNotification(
                    recipient: $user->email,
                    subject: 'email',
                    body: $dto->messageContent
                );
            } elseif ($providerType === 'sms') {
                return $this->service->sendSmsNotification(
                    recipient: $user->email,
                    message: $dto->messageContent
                );
            }
        }

        //TODO check user prefrence
        if ($dto->preferredNotificationType === 'email') {
            return $this->service->sendEmailNotification(
                recipient: $user->email,
                subject: 'email',
                body: $dto->messageContent
            );
        } elseif ($dto->preferredNotificationType === 'sms') {
            return $this->service->sendSmsNotification(
                recipient: $user->email,
                message: $dto->messageContent
            );
        }
    }
}
