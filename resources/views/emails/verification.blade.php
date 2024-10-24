<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de correo</title>
</head>
<body>
    <h1>Hola, {{ $user->name }}</h1>
    <p>Gracias por registrarte. Por favor, haz clic en el siguiente enlace para verificar tu correo electrónico:</p>
    <a href="{{ $verificationUrl }}">Verificar mi correo</a>
</body>
</html>
