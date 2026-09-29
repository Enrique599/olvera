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
        <div class="step-dot done">✓</div>
        <div class="step-line done"></div>
        <div class="step-dot active">2</div>
        <div class="step-line"></div>
        <div class="step-dot">3</div>
    </div>

    <h1>🔑 Recuperar contraseña</h1>
    <p class="subtitle">Crea tu nueva contraseña</p>

    <div class="form-card">

        <div class="cliente-info">👤 Cuenta encontrada: <strong>{{ $cliente->nombre_completo }}</strong></div>

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('tienda.recuperar.guardar') }}" method="post">
            @csrf
            <div class="fg">
                <label>Nueva contraseña</label>
                <div class="icon-input"><span>🔒</span>
                <input type="password" name="nueva" placeholder="Mínimo 6 caracteres" required autofocus></div>
            </div>

            <div class="fg">
                <label>Confirmar contraseña</label>
                <div class="icon-input"><span>🔑</span>
                <input type="password" name="confirmar" placeholder="Repite la nueva contraseña" required></div>
            </div>

            <button type="submit" class="btn-primary">💾 Guardar contraseña</button>
            <a href="{{ route('tienda.recuperar') }}" class="btn-back">← Volver</a>
        </form>

    </div>
</div>

</body>
</html>
