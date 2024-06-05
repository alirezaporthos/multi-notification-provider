<?php

namespace App\Services\PorthosNotification\Providers\Sms;

use App\Services\PorthosNotification\Contracts\Sms\SmsProviderInterface;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class TwilioSmsServiceProvider implements SmsProviderInterface
{
    //TODO Put config files to a config file

    private $twilioClient;

    public function __construct()
    {
        $this->twilioClient = new Client(
            env('TWILIO_SID'),
            env('TWILIO_TOKEN')
        );
    }

    public function send(string $recipient, string $message): bool
    {
        try {
            $response = $this->twilioClient->messages->create(
                $recipient,
                [
                    'from' => env('TWILIO_FROM'),
                    'body' => $message,
                ]
            );
        } catch (RestException $e) {
            Log::error("Failed to send SMS via Twilio: {$e->getMessage()}");
            return false;
        }

        return true;
    }
}
