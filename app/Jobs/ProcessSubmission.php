<?php

namespace App\Jobs;

use App\Models\Submission;
use App\Events\SubmissionSaved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            $submission = Submission::create($this->data);

            event(new SubmissionSaved($submission->name, $submission->email));

        } catch (Throwable $e) {
            Log::error('Error processing submission', ['exception' => $e]);

            // Rethrow the exception if you want the job to be retried
            throw $e;
        }
    }
}
