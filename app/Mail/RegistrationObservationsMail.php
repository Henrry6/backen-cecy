<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationObservationsMail extends Mailable
{
    use Queueable, SerializesModels;

public $courseName;
public $observations;
public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course,$observations,$name)
    {
       $this->courseName = $course;
       $this->name = $name;
       $this->observations = $observations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.registration.observations');
    }
}
