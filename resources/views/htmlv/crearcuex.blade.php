<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta creada — DAV Tienda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tienda/cuenta.css') }}">
</head>
<body>

    <header class="site-header">
        <img src="{{ asset('img/tienda/logo.jpg') }}" alt="Logo">
        <div class="brand">DAV <span>Tienda</span></div>
    </header>

    <div class="card-wrap">
        <h1>Crear cuenta</h1>
        <p class="subtitle">Regístrate para empezar a comprar</p>

        <div class="form-card">
            <div class="success-screen">
                <div class="success-icon">🎉</div>
                <h2>¡Cuenta creada!</h2>
                <p>Tu cuenta fue registrada exitosamente.<br>Ya puedes iniciar sesión.</p>
                <a href="{{ route('tienda.login') }}" class="btn-go">Iniciar sesión →</a>
            </div>
        </div>
    </div>

</body>
</html>
