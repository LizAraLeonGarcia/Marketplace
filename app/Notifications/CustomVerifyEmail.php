<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Construir el mensaje de correo.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
                    ->subject('Verifica tu dirección de correo')
                    ->line('Haz clic en el siguiente enlace para verificar tu dirección de correo electrónico.')
                    ->action('Verificar correo', $url)
                    ->line('Si no creaste una cuenta, no es necesario hacer nada.');
    }
}
