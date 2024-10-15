<nav>
    <ul>
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="{{ route('productos.index') }}">Productos</a></li>
        <li><a href="{{ route('dashboard') }}">Mi Cuenta</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link">Cerrar Sesión</button>
            </form>
        </li>
    </ul>
</nav>
