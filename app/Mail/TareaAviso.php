<?php

namespace App\Mail;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TareaAviso extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tarea;

    /**
     * Create a new message instance.
     */
    public function __construct($tarea, $user)
    {
        $this->user  = $user;
        $this->tarea = $tarea;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'TAREA REALIZADA',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.aviso',
            with:[
                'user'      => $this->user,
                'tarea'     => $this->tarea
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [ ];
    }
}
