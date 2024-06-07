<?php

namespace App\Listeners;

use App\Events\UserPrefrenceSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CacheUserPreferenceListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserPrefrenceSaved $event): void
    {
        $userPrefrence = $event->userPrefrence;
        Cache::put("user:{$userPrefrence->user_id}:notification_prefrences", $userPrefrence, now()->addHours(24));
    }
}
