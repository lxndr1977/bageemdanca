<?php

namespace App\Mail;

use App\Models\Registration;
use App\Models\SystemConfiguration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class RegistrationFinished extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Registration $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmação de Inscrição - Bagé em Dança',
            from: new Address('naoresponda@inscricoes.bageemdanca.com.br', 'Bagé em Dança'),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.registration.finished',
            with: [
                'registration'  => $this->registration,
                'school'        => $this->registration->school,
                'user'          => $this->registration->school->user,
                'systemConfig'  => SystemConfiguration::first(),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}