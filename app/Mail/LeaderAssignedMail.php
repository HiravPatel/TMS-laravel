<?php

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaderAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

     public $project;
    /**
     * Create a new message instance.
     *
     * @return void
     * 
     * 
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->subject('You have been selected as Leader.')
                    ->view('leader_assigned');
    }
}
