@extends('layouts.admin')

@section('titulo', 'Respaldar Base de Datos')

@section('contenido')
<div class="ptitle">Respaldar Base de Datos</div>
<div class="psub">Genera y descarga una copia de seguridad de los datos del sistema</div>

<div class="alert alert-warn" style="margin-bottom:18px">
  <i class="fas fa-info-circle"></i> El respaldo incluye todos los datos de las tablas del sistema (clientes, ventas, prendas, productos, empleados, proveedores, pedidos, etc).
</div>

<div class="fcard" style="max-width:520px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:6px"><i class="fas fa-database" style="color:var(--accent)"></i> Respaldo completo (.sql)</div>
  <div style="font-size:12.5px;color:var(--muted);margin-bottom:18px">Se descargará un archivo <span class="bg-zip">respaldo_AAAA-MM-DD_HH-MM-SS.sql</span></div>
  <div style="display:flex;gap:10px">
    <a href="{{ route('admin.respaldar.descargar') }}" class="btn btn-teal"><i class="fas fa-download"></i> Generar y descargar respaldo</a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Volver</a>
  </div>
</div>
@endsection
