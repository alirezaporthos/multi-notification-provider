<?php

namespace App\Services\PorthosNotification\Contracts\Email;

interface EmailProviderInterface
{
    public function send($recipient, string $body, string $subject): bool;
}
