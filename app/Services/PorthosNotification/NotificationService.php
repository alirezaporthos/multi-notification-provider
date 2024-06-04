<?php

namespace App\Services\PorthosNotification;

use App\Services\PorthosNotification\Contracts\Email\EmailProviderInterface;
use App\Services\PorthosNotification\Contracts\Sms\SmsProviderInterface;

class NotificationService
{
    protected $emailProvider;
    protected $smsProvider;

    public function __construct(EmailProviderInterface $emailProvider, SmsProviderInterface $smsProvider)
    {
        $this->emailProvider = $emailProvider;
        $this->smsProvider = $smsProvider;
    }

    public function sendEmailNotification($message, $recipient)
    {
        return $this->emailProvider->send($message, $recipient);
    }

    public function sendSmsNotification($message, $recipient)
    {
        return $this->smsProvider->send($message, $recipient);
    }
}
