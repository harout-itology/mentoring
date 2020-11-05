<?php

namespace App\Listeners;

use App\Events\DataRead;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;


class LogListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(DataRead $event)
    {
        // log the user and the results
        Log::info($event->user);
        Log::info($event->data);
    }
}
