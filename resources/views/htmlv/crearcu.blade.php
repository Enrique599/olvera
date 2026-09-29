<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta — DAV Tienda</title>
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

            @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
            <form action="{{ route('tienda.registro.post') }}" method="post">
                @csrf
                <div class="form-row">
                    <div class="fg">
                        <label>Nombre</label>
                        <div class="icon-input"><span>👤</span>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label>Apellido Paterno</label>
                        <div class="icon-input"><span>👥</span>
                            <input type="text" name="paterno" value="{{ old('paterno') }}" placeholder="Apellido" required>
                        </div>
                    </div>
                </div>

                <div class="fg">
                    <label>Teléfono (se usará para iniciar sesión)</label>
                    <div class="icon-input"><span>📞</span>
                        <input type="tel" name="telefono" value="{{ old('telefono') }}" placeholder="10 dígitos" maxlength="10" pattern="[0-9]{10}"
                               title="Por favor, introduce exactamente 10 dígitos numéricos." required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="fg">
                        <label>Contraseña</label>
                        <div class="icon-input"><span>🔒</span>
                            <input type="password" name="contrasena" placeholder="Mínimo 6 caracteres" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label>Confirmar contraseña</label>
                        <div class="icon-input"><span>🔑</span>
                            <input type="password" name="confirmar" placeholder="Repite la contraseña" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="fg">
                        <label>Dirección</label>
                        <div class="icon-input"><span>🏠</span>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Tu dirección" required>
                        </div>
                    </div>
                    <div class="fg">
                        <label>Código Postal</label>
                        <div class="icon-input"><span>📮</span>
                            <input type="text" name="cp" value="{{ old('cp') }}" placeholder="5 dígitos" maxlength="5" required>
                        </div>
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-primary">✅ Crear cuenta</button>
                    <a href="{{ route('tienda.inicio') }}" class="btn-cancel">✖ Cancelar</a>
                </div>
            </form>

            <div class="divider">— ¿Ya tienes cuenta? —</div>
            <div class="link-login"><a href="{{ route('tienda.login') }}">Iniciar sesión aquí</a></div>

        </div>
    </div>

</body>
</html>
