<?php

namespace App\Services\PorthosNotification;

use Aws\Ses\SesClient;
use Illuminate\Support\ServiceProvider;
use Plivo\RestClient;
use SendGrid;
use Twilio\Rest\Client;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //TODO get rid of these env variables, put them in a config
        $this->app->bind(SendGrid::class, function ($app) {
            return new SendGrid(env('SENDGRID_API_KEY'));
        });

        $this->app->bind(SesClient::class, function ($app) {
            return new SesClient([
                'version' => 'latest',
                'region'  => 'us-west-2',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
        });

        $this->app->bind(RestClient::class, function ($app) {
            return new RestClient(
                env('PLIVO_AUTH_TOKEN'),
                env('PLIVO_PHONE_NUMBER')
            );
        });

        $this->app->bind(Client::class, function ($app) {
            return new Client(
                env('TWILIO_SID'),
                env('TWILIO_TOKEN')
            );
        });
    }
}
