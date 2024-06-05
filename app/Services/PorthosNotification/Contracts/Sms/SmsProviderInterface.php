<?php

namespace App\Services\PorthosNotification\Contracts\Sms;

interface SmsProviderInterface
{
    public function send(string $recipient, string $message): bool;
}
