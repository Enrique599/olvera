<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña actualizada — DAV Tienda</title>
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
        <div class="step-dot done">✓</div>
        <div class="step-line done"></div>
        <div class="step-dot done">✓</div>
    </div>

    <h1>🔑 Recuperar contraseña</h1>
    <p class="subtitle">Contraseña actualizada</p>

    <div class="form-card">
        <div class="success-screen">
            <div class="success-icon">🎊</div>
            <h2>¡Contraseña actualizada!</h2>
            <p>Tu contraseña fue cambiada exitosamente.<br>Ahora puedes iniciar sesión.</p>
            <a href="{{ route('tienda.login') }}" class="btn-go">Iniciar sesión →</a>
        </div>
    </div>
</div>

</body>
</html>
