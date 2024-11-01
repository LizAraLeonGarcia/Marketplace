<x-mail::message>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos en línea para asegurar la compatibilidad con diferentes clientes de correo */
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .button {
            background-color: #800080; /* violeta */
            color: #ffffff !important; /* blanco */
            padding: 12px 24px; /* Aumentar el tamaño del botón */
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px; /* Tamaño de fuente */
            font-weight: bold; /* Negrita */
            transition: background-color 0.3s ease; /* Transición suave al pasar el mouse */
            border: none; /* Sin borde */
            outline: none; /* Sin contorno */
        }
        h1 { color: #FFC0CB !important; } /* rosa */
        h2 { color: #28a745; } /* Verde */
        h3 { color: #0000FF; } /* azul */
        h4 { color: #000000; } /* negro */
    </style>
</head>
<body>
    <div class="container">
        <img src="http://127.0.0.1:8000/img/logo.jpg" alt="Vaquita Marketplace" style="width: 100px; height: auto;">
        <h1>¡Hola, {{ $producto->user->name }}!</h1>
        <h2>¡Has creado tu primer producto!</h2>
        <h3>Aquí tienes algunos de los detalles que has incluido en dicho producto:</h3>
        <h4>{{ $producto->nombre }}</h4>
        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
        <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
        <p><strong>Stock:</strong> {{ $producto->stock }}</p>
        <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
        <a href="{{ url('/productos/' . $producto->id) }}" class="button">Ver producto</a>
        <h4>¡Muchas gracias por usar <strong>VaquitaMarketplace</strong>!</h4>
    </div>
</body>
</html>
</x-mail::message>
