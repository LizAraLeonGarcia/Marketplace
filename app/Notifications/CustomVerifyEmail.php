<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    public function __construct()
    {
    }

    public function via($notifiable)
    {
        return ['mail']; // Envía la notificación por correo
    }
    
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->greeting('¡Hola!')
            ->subject('Verifica tu correo electrónico')
            ->line('Por favor haz clic en el siguiente enlace para verificar tu correo.')
            ->action('Verificar correo electrónico', $verificationUrl)
            ->line('Si no solicitaste esta verificación, puedes ignorar este mensaje.')
            ->salutation('¡Saludos, Vaquita Marketplace!');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
