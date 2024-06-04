<?php

namespace App\Services\PorthosNotification\Contracts\Sms;

interface SmsProviderInterface
{
    public function send($message, $recipient): bool;
}
