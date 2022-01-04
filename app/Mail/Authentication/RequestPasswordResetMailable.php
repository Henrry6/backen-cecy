<?php

namespace App\Mail\Authentication;

use App\Models\Authentication\System;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestPasswordResetMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    private $data;
    private $pathAttaches;
    private $system;

    public function __construct($subject, $data, $pathAttaches = null, $system = 1)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->pathAttaches = $pathAttaches;
        $this->system = System::find($system);
    }

    public function build()
    {
        if (!is_null($this->pathAttaches)) {
            foreach ($this->pathAttaches as $pathAttach) {
                $this->attachFromStorage('public/temp_files/' . $pathAttach);
            }
        }

        return $this->view('mails.authentication.request-password-reset')
            ->with(['data' => json_decode($this->data), 'system' => $this->system]);
    }
}
