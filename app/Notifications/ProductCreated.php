<?php

namespace App\Notifications;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProductCreated extends Notification
{
    use Queueable;
    protected $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tu primer producto Creado')
            ->markdown('emails.primer_producto', ['producto' => $this->producto]);
    }
}
