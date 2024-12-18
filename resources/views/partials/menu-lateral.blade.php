<div class="custom-menu"> 
    <ul class="list-group">
        <h5 class="list-group-item list-group-item-action active" aria-current="true">
            Menú
        </h5>
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('mi-cuenta') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-user"></i> Mi cuenta
        </a>
        <a href="{{ route('comprador.perfil') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-shopping-bag"></i> Ver mi perfil como comprador
        </a>
        <a href="{{ route('vendedor.perfil') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-store"></i> Ver mi perfil como vendedor
        </a>
        <a href="{{ route('productos.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-plus-circle"></i> Crear producto
        </a>
        <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-box-open"></i> Ver productos
        </a>
        <a href="{{ route('carrito.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-shopping-cart"></i> Carrito
        </a>
        <a href="{{ route('ayuda.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
            <i class="fas fa-headset"></i> Ayuda
        </a>
        <div class="sidebar-header">
            <img src="{{ asset('assets/img/menuLateralDashboard.png') }}" alt="Imagen del menu lateral" class="img-fluid">
        </div>
        <a href="{{ route('logout') }}" class="btn btn-link-danger" title="Cerrar sesión" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </ul>
</div>