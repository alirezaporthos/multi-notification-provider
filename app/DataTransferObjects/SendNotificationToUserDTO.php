<?php

namespace App\DataTransferObjects;

use Illuminate\Contracts\Support\Arrayable;

class SendNotificationToUserDTO implements Arrayable
{
    public function __construct(
        public string $userId,
        public string $messageContent,
        public ?string $preferredNotificationType
    ) {
    }

    public function toArray()
    {
        return [
            'userId' => $this->userId,
            'messageContent' => $this->messageContent,
            'preferredNotificationType' => $this->preferredNotificationType,
        ];
    }
}
