<?php

namespace App\Listeners;

use App\Events\SubmissionSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogSubmissionSaved
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\SubmissionSaved  $event
     * @return void
     */
    public function handle(SubmissionSaved $event)
    {
        Log::info('Submission saved successfully', ['name' => $event->name, 'email' => $event->email]);
    }
}
