<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/tienda/inicio.css') }}">
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
            <a href="#" onclick="event.preventDefault();document.getElementById('form-logout').submit()">Cerrar sesión ({{ session('cliente.nombre') }})</a>
        </nav>
        <form id="form-logout" action="{{ route('tienda.logout') }}" method="post" style="display:none">@csrf</form>
    </header>

    <section class="productos">

        <div class="producto">
            <div class="titulo">Oferta del día</div>
            <img src="{{ asset('img/tienda/ves1.jpg') }}" alt="">
        </div>

        <div class="producto">
            <div class="titulo">Menos de $100</div>
            <img src="{{ asset('img/tienda/ves2.jpg') }}" alt="">
            <div class="precio">$65</div>
        </div>

        <div class="producto">
            <div class="titulo">Mas vendidos</div>
            <img src="{{ asset('img/tienda/ves3.jpg') }}" alt="">
            <div class="precio">$117</div>
        </div>

    </section>

    <footer>
        <p>Visítanos en:</p>
        <p>C. Reforma, San Lucas Atoyatenco,</p>
        <p>74053 San Martín Texmelucan de Labastida Puebla</p>
    </footer>

</div>

</body>
</html>
