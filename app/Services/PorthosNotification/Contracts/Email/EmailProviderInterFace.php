<?php

namespace App\Services\PorthosNotification\Contracts\Email;

interface EmailProviderInterface
{
    public function send($message, $recipient): bool;
}
