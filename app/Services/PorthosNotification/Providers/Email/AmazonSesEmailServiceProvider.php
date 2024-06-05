<?php

namespace App\Services\PorthosNotification\Providers\Email;

use App\Services\PorthosNotification\Contracts\Email\EmailProviderInterface;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class AmazonSesEmailServiceProvider implements EmailProviderInterface
{

    public function __construct(private SesClient $sesClient)
    {
    }

    //TODO check the recipent of other providers and look for a type for all if possible
    public function send($recipient, string $subject, string $body): bool
    {
        try {
            $result = $this->sesClient->sendEmail(
                [
                    'Destination' => [
                        'ToAddresses' => [$recipient],
                    ],
                    'FromEmailAddress' => env('EMAIL_FROM_ADDRESS'),
                    'Content' => [
                        'Simple' => [
                            'Body' => [
                                'Text' => [
                                    'Charset' => 'UTF-8',
                                    'Data' => $body,
                                ],
                            ],
                            'Subject' => [
                                'Charset' => 'UTF-8',
                                'Data' => $subject,
                            ],
                        ],
                    ],
                ]
            );
        } catch (\Aws\Exception\AwsException $e) {

            Log::error("Failed to send email via Amazon SES: {$e->getMessage()}");

            return false;
        }

        return true;
    }
}
