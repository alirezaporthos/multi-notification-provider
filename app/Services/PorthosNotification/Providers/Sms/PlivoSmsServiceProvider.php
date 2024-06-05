<?php

namespace App\Services\PorthosNotification\Providers\Sms;

use App\Services\PorthosNotification\Contracts\Sms\SmsProviderInterface;
use Illuminate\Support\Facades\Log;
use Plivo\Exceptions\PlivoRestException;
use Plivo\RestClient;

class PlivoSmsServiceProvider implements SmsProviderInterface
{

    public function __construct(private RestClient $plivoClient)
    {
    }


    public function send(string $recipient, string $message): bool
    {
        try {
            $response = $this->plivoClient->messages->create(
                $recipient,
                [
                    'text' => $message,
                    'from' => env('PLIVO_PHONE_NUMBER'),
                ]
            );
        } catch (PlivoRestException $exception) {
            Log::error("Failed to send SMS via Plivo: {$exception->getMessage()}");
            return false;
        }
        return true;
    }
}
