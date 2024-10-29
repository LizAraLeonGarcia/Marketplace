<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Producto;

class PrimerProductoMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $producto;

    public function __construct(Producto $producto, $user)
    {
        $this->user = $user;
        $this->producto = $producto;
    }

    public function build()
    {
        return $this->markdown('emails.primer_producto')
                    ->subject('¡Has creado tu primer producto!')
                    ->with(['producto' => $this->producto]);
    }
}
