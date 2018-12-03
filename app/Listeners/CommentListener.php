<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentListener
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
     * @param  FovariteEvent  $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {
        //
    }
}
