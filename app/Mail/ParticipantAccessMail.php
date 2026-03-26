<?php

namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ParticipantAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $qrCodeSvg;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu código de acceso oficial - Feria de la Francofonía',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.participant_access',
        );
    }
}
