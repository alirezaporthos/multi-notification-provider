<?php

namespace App\Services\PorthosNotification;

use App\Services\PorthosNotification\Contracts\Email\EmailProviderInterface;
use App\Services\PorthosNotification\Contracts\Sms\SmsProviderInterface;
use App\Services\PorthosNotification\Providers\Email\AmazonSesEmailServiceProvider;
use App\Services\PorthosNotification\Providers\Email\SendGridEmailServiceProvider;
use App\Services\PorthosNotification\Providers\Sms\PlivoSmsServiceProvider;
use App\Services\PorthosNotification\Providers\Sms\TwilioSmsServiceProvider;
use Exception;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    protected array $emailProviders;

    protected array $smsProviders;

    public function __construct()
    {
        $this->registerProviders();
    }

    protected function registerProviders()
    {
        $this->emailProviders[] = AmazonSesEmailServiceProvider::class;
        $this->emailProviders[] = SendGridEmailServiceProvider::class;

        $this->smsProviders[] = PlivoSmsServiceProvider::class;
        $this->smsProviders[] = TwilioSmsServiceProvider::class;
    }

    public function sendEmailNotification($recipient, $subject, $body)
    {

        foreach ($this->emailProviders as $emailProviderClass) {
            //TODO: you can get rid of this try catch here or in the providers
            try {
                $emailProvider = app($emailProviderClass);
                if ($emailProvider->send($recipient, $subject, $body)) {
                    return true;
                }
            } catch (Exception $e) {
                Log::error("Failed to send email via {$emailProviderClass}: " . $e->getMessage());
            }
        }

        Log::error("All email providers failed to send the email.");
        return false;
    }

    public function sendSmsNotification($recipient, $message)
    {
        foreach ($this->smsProviders as $smsProviderClass) {
            //TODO: you can get rid of this try catch here or in the providers
            try {
                $smsProvider = app($smsProviderClass);
                if ($smsProvider->send($recipient, $message)) {
                    return true;
                }
            } catch (Exception $e) {
                Log::error("Failed to send sms via {$smsProviderClass}: " . $e->getMessage());
            }
        }

        Log::error("All sms providers failed to send the sms.");
        return false;
    }
}
