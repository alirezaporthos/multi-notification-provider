<?php

namespace App\Services\PorthosNotification\Providers\Email;

use App\Services\PorthosNotification\Contracts\Email\EmailProviderInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;

class SendGridEmailServiceProvider implements EmailProviderInterface
{

    public function __construct(private SendGrid $sendGridClient)
    {
    }

    public function send($recipent, string $subject, string $body): bool
    {
        $mail = new Mail();
        $mail->addTo($recipent);
        $mail->setFrom(env('EMAIL_FROM_ADDRESS'), env('APP_NAME'));
        $mail->setSubject($subject);
        $mail->addContent("text/plain", $body);
        // ->addContent("text/html", "<strong>And HTML like this.</strong>") // HTML content

        try {
            $request = $this->sendGridClient->send($mail);
        } catch (Exception $e) {

            Log::error("Failed to send email via SendGrid: {$e->getMessage()}");
            return false;
        }

        return true;
    }
}
