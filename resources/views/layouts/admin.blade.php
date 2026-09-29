<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('titulo') — Sistema DAV</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
  @stack('head')
</head>
<body>
@php
  $admin = session('admin', ['nombre' => 'Administrador', 'rol' => 'admin']);
  $iniciales = collect(explode(' ', $admin['nombre']))->filter()->take(2)
      ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
  $act = fn (string $patron) => request()->routeIs($patron) ? 'act' : '';
@endphp

  <!-- SIDEBAR -->
  <nav id="sb">
    <div class="sb-head">
      <div class="logo-c"><img src="{{ asset('img/admin/logo.jpeg') }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;" onerror="this.style.display='none';this.parentElement.textContent='⚙'"></div>
      <div class="logo-t">SistemaCRUD</div>
    </div>
    <div class="sb-user">
      <div class="av">{{ $iniciales }}</div>
      <div>
        <div class="un">{{ $admin['nombre'] }}</div>
        <div class="ur">{{ \App\Models\Empleado::ROLES[$admin['rol']] ?? ucfirst($admin['rol']) }}</div>
      </div>
    </div>

    <div class="sb-lbl">Principal</div>
    <a href="{{ route('admin.dashboard') }}" class="ni {{ $act('admin.dashboard') }}">
      <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
    </a>

    <div class="sb-lbl">Operatividad</div>
    <a href="{{ route('admin.ventas.index') }}" class="ni {{ $act('admin.ventas.*') }}">
      <i class="fas fa-dollar-sign"></i><span>Ventas</span>
    </a>
    <a href="{{ route('admin.pedidos-clientes.index') }}" class="ni {{ $act('admin.pedidos-clientes.*') }}">
      <i class="fas fa-box"></i><span>Pedidos de clientes</span>
    </a>
    <a href="{{ route('admin.pedidos-proveedores.index') }}" class="ni {{ $act('admin.pedidos-proveedores.*') }}">
      <i class="fas fa-truck-loading"></i><span>Pedidos a proveedores</span>
    </a>
    <a href="{{ route('admin.proveedores.index') }}" class="ni {{ $act('admin.proveedores.*') }}">
      <i class="fas fa-clipboard-list"></i><span>Registro proveedores</span>
    </a>
    <a href="{{ route('admin.pagos.index') }}" class="ni {{ $act('admin.pagos.*') }}">
      <i class="fas fa-money-check-dollar"></i><span>Validación de pago</span>
    </a>

    <div class="sb-lbl">Catálogos</div>
    <a href="{{ route('admin.clientes.index') }}" class="ni {{ $act('admin.clientes.*') }}">
      <i class="fas fa-users"></i><span>Clientes</span>
    </a>
    <a href="{{ route('admin.prendas.index') }}" class="ni {{ $act('admin.prendas.*') }}">
      <i class="fas fa-shirt"></i><span>Prendas</span>
    </a>
    <a href="{{ route('admin.productos.index') }}" class="ni {{ $act('admin.productos.*') }}">
      <i class="fas fa-box-open"></i><span>Productos</span>
    </a>
    <a href="{{ route('admin.usuarios.index') }}" class="ni {{ $act('admin.usuarios.*') }}">
      <i class="fas fa-user-gear"></i><span>Usuarios</span>
    </a>
    <a href="{{ route('admin.inventario.index') }}" class="ni {{ $act('admin.inventario.*') }}">
      <i class="fas fa-warehouse"></i><span>Inventario</span>
    </a>
    <a href="{{ route('admin.proveedores.index') }}" class="ni">
      <i class="fas fa-truck"></i><span>Proveedores</span>
    </a>

    <div class="sb-lbl">Sistema</div>
    <a href="{{ route('admin.respaldar') }}" class="ni {{ $act('admin.respaldar*') }}">
      <i class="fas fa-download"></i><span>Respaldar BD</span>
    </a>
    <a href="{{ route('admin.restaurar') }}" class="ni {{ $act('admin.restaurar*') }}">
      <i class="fas fa-upload"></i><span>Restaurar BD</span>
    </a>
    <a href="{{ route('admin.reporte') }}" class="ni {{ $act('admin.reporte*') }}">
      <i class="fas fa-file-pdf"></i><span>Reporte PDF</span>
    </a>
    <a href="#" class="ni" onclick="event.preventDefault();document.getElementById('form-logout').submit()">
      <i class="fas fa-right-from-bracket"></i><span>Cerrar sesión</span>
    </a>
    <form id="form-logout" action="{{ route('admin.logout') }}" method="post" style="display:none">@csrf</form>
  </nav>

  <!-- MAIN -->
  <div id="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <button class="tb-toggle" onclick="toggleSB()"><i class="fas fa-bars"></i></button>
      <div class="tb-title">@yield('titulo')</div>
      <div style="font-size:11.5px;color:var(--muted)">
        Home / <span style="color:var(--accent)">@yield('titulo')</span>
      </div>
      <div class="tb-right">
        <div class="tb-icon"><i class="fas fa-bell"></i></div>
        <div class="av" style="cursor:pointer">{{ $iniciales }}</div>
      </div>
    </div>

    <div id="content">
      @if (session('ok'))
        <div class="alert alert-ok"><i class="fas fa-check-circle"></i> {{ session('ok') }}</div>
      @endif
      @if (session('err'))
        <div class="alert alert-err"><i class="fas fa-times-circle"></i> {{ session('err') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-err" style="flex-direction:column;align-items:flex-start">
          @foreach ($errors->all() as $error)
            <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
          @endforeach
        </div>
      @endif

      @yield('contenido')
    </div><!-- end #content -->
  </div><!-- end #main -->

  <script>
  function toggleSB(){
    document.getElementById('sb').classList.toggle('col');
    document.body.classList.toggle('col-mode');
  }
  </script>
  @stack('scripts')
</body>
</html>
