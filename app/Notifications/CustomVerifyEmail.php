<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Confirma tu correo electrónico')
            ->greeting('¡Hola, ' . $notifiable->name . '!')
            ->line('Gracias por registrarte en VaquitaMarketplace. Por favor, confirma tu correo electrónico.')
            ->action('Verificar Correo', $verificationUrl)
            ->line('Aviso: Después de verificar, serás redirigido a tu dashboard.')
            ->markdown('emails.verify-email', ['url' => $verificationUrl, 'user' => $notifiable]);
    }

    public function verificationUrl($notifiable)
    {
        return URL::signedRoute('verification.verify', [
            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]);
    }
}
