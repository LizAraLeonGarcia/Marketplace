<nav>
    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="{{ route('productos.index') }}">Productos</a></li>
        @auth
            <li><a href="mi-cuenta">Mi cuenta</a></li>
        @else
            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
        @endauth
    </ul>
</nav>
