@component('mail::message')
<img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="width: 100px; height: auto;">

# ¡Hola, {{ $user->name }}!

Gracias por registrarte en **VaquitaMarketplace**. Solo falta un paso más.

@component('mail::button', ['url' => $url])
Verificar Correo
@endcomponent

Una vez que verifiques tu correo, serás redirigido a tu dashboard.

Gracias por ser parte de nuestra comunidad,  
**VaquitaMarketplace**

@endcomponent
