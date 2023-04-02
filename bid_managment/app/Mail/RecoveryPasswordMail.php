<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecoveryPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $userName;
    private string $accessToken;

    public function __construct(string $userName, string $accessToken)
    {
        $this->userName = $userName;
        $this->accessToken = $accessToken;
    }

    public function build()
    {
        return $this->view('mail.recovery')->with([
            "userName"=> $this->userName,
            "accessToken" => $this->accessToken
        ]);
    }
}
