<?php

namespace App\Mail;

use App\Helpers\ConfirmarEmailHelper;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmarCadastroMail extends Mailable
{
    use Queueable, SerializesModels;

    public Usuario $usuario;

    private string $pathConfirmacao;
    private string $hashConfirmacao;

    /**
     * Create a new message instance.
     */
    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->hashConfirmacao = ConfirmarEmailHelper::hash($this->usuario);
        $this->pathConfirmacao = "/user/confirm/{$this->hashConfirmacao}";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirme o seu cadastro',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $url = url($this->pathConfirmacao);

        return new Content(
            markdown: 'emails.confirmar_cadastro',
            with: [
                'usuario' => $this->usuario,
                'urlConfirmacao' => $url
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        return [];
    }
}
