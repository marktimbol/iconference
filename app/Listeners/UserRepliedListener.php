<?php

namespace App\Listeners;

use App\Events\UserReplied;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRepliedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserReplied  $event
     * @return void
     */
    public function handle(UserReplied $event)
    {
        //
    }
}
