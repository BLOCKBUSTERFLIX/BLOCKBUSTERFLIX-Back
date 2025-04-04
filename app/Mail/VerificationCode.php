<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $twoFactorCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($twoFactorCode)
    {
        $this->twoFactorCode = $twoFactorCode;
    }

    public function build()
    {
        return $this->subject('Código de Verificación')
        ->view('emails.code')
        ->with([
            'twoFactorCode' => $this->twoFactorCode,
        ]);
    }
}
