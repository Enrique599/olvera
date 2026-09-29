<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña — DAV Tienda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tienda/recuperar.css') }}">
</head>
<body>

<header class="site-header">
    <img src="{{ asset('img/tienda/logo.jpg') }}" alt="Logo">
    <div class="brand">DAV <span>Tienda</span></div>
</header>

<div class="card-wrap">

    <div class="steps">
        <div class="step-dot active">1</div>
        <div class="step-line"></div>
        <div class="step-dot">2</div>
        <div class="step-line"></div>
        <div class="step-dot">3</div>
    </div>

    <h1>🔑 Recuperar contraseña</h1>
    <p class="subtitle">Verifica tu número de teléfono</p>

    <div class="form-card">

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('tienda.recuperar.buscar') }}" method="post">
            @csrf
            <div class="fg">
                <label>Número de teléfono</label>
                <div class="icon-input"><span>📞</span>
                <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="El teléfono de tu cuenta" required autofocus></div>
                <span class="help-text">Ingresa el número con el que creaste tu cuenta</span>
            </div>

            <button type="submit" class="btn-primary">🔍 Buscar cuenta</button>
            <a href="{{ route('tienda.login') }}" class="btn-back">← Volver al inicio de sesión</a>
        </form>

    </div>
</div>

</body>
</html>
