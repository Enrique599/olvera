<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <link rel="stylesheet" href="{{ asset('css/tienda/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tienda/categorias.css') }}">
</head>
<body>

<div class="contenedor">

    <header>
        <div class="top-header">
            <div class="logo">
                <img src="{{ asset('img/tienda/logo.jpg') }}" alt="Logo de Ventas">
            </div>

            <div class="barra-busqueda">
                <input type="text" placeholder="Buscar">
                <span>🔍</span>
            </div>
        </div>

        <nav>
            <a href="{{ route('tienda.categorias') }}">Categorías</a>
            <a href="#">Ofertas</a>
            @if (session()->has('cliente'))
                <a href="{{ route('tienda.tienda') }}">Mi tienda</a>
            @else
                <a href="{{ route('tienda.login') }}">Iniciar sesión</a>
                <a href="{{ route('tienda.registro') }}">Crear Cuenta</a>
            @endif
        </nav>
    </header>

    <div class="categorias-titulo">Categorías</div>

    <section class="categorias-grid">
        @forelse ($categorias as $categoria)
            <a href="#" class="categoria-card">
                <img src="{{ asset('img/tienda/' . ($categoria->imagen ?? 'logo.jpg')) }}" alt="{{ $categoria->nombre }}"
                     onerror="this.onerror=null;this.src='{{ asset('img/tienda/logo.jpg') }}'">
                <div class="nombre">{{ $categoria->nombre }}</div>
                <div class="cantidad">{{ $categoria->productos_count }} {{ $categoria->productos_count === 1 ? 'producto' : 'productos' }}</div>
            </a>
        @empty
            <p style="grid-column:1/-1;text-align:center">Todavía no hay categorías.</p>
        @endforelse
    </section>

    <footer>
        <p>Visítanos en:</p>
        <p>C. Reforma, San Lucas Atoyatenco,</p>
        <p>74053 San Martín Texmelucan de Labastida Puebla</p>
    </footer>

</div>

</body>
</html>
