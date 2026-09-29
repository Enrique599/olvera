@extends('layouts.admin')

@section('titulo', 'Reporte PDF')

@section('contenido')
<div class="ptitle">Reporte PDF</div>
<div class="psub">Genera un reporte en PDF con el listado completo de clientes</div>

<div class="fcard" style="max-width:520px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:6px"><i class="fas fa-file-pdf" style="color:var(--red)"></i> Reporte de Clientes</div>
  <div style="font-size:12.5px;color:var(--muted);margin-bottom:18px">Incluye ID, nombre, teléfono, dirección y código postal de todos los clientes registrados, con fecha y hora de generación.</div>
  <a href="{{ route('admin.reporte.clientes') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Generar reporte PDF</a>
</div>
@endsection
