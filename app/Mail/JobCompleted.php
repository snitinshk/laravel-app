<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $job_name)
    {
        $this->first_name = $first_name;
        $this->job_name = $job_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.jobcompleted')
            ->with([
                'first_name' => $this->first_name,
                'job_name' => $this->job_name,
            ]);
    }
}
