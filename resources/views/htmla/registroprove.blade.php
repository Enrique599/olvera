@extends('layouts.admin')

@section('titulo', 'Registro de Proveedores')

@section('contenido')
<div class="ptitle">Registro de Proveedores</div>
<div class="psub">{{ $saludo }} — Administra tu catálogo de proveedores</div>

<div class="fcard" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px"><i class="fas fa-clipboard-list" style="color:var(--accent3)"></i> {{ $registro ? 'Editar proveedor' : 'Agregar nuevo proveedor' }}</div>
  <form action="{{ $registro ? route('admin.proveedores.update', $registro) : route('admin.proveedores.store') }}" method="post">
    @csrf
    @if ($registro) @method('PUT') @endif
    <div class="fgrid">
      <div class="fg"><label>Nombre *</label><input class="fc" type="text" name="nombre" value="{{ old('nombre', $registro?->nombre) }}" placeholder="Nombre" required></div>
      <div class="fg"><label>Apellido Paterno *</label><input class="fc" type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $registro?->apellido_paterno) }}" placeholder="Apellido" required></div>
      <div class="fg"><label>Teléfono *</label><input class="fc" type="text" name="telefono" value="{{ old('telefono', $registro?->telefono) }}" placeholder="10 dígitos" maxlength="10" required></div>
      <div class="fg"><label>Dirección *</label><input class="fc" type="text" name="direccion" value="{{ old('direccion', $registro?->direccion) }}" placeholder="Dirección completa" required></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $registro ? 'Actualizar proveedor' : 'Guardar proveedor' }}</button>
    @if ($registro)
      <a href="{{ route('admin.proveedores.index') }}" class="btn btn-outline">Cancelar</a>
    @endif
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-clipboard-list" style="color:var(--accent3)"></i> Lista de Proveedores</div></div>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th><th>Dirección</th><th>Modificar</th><th>Eliminar</th></tr></thead>
    <tbody>
      @forelse ($proveedores as $p)
        <tr>
          <td>{{ $p->id }}</td><td>{{ $p->nombre }}</td><td>{{ $p->apellido_paterno }}</td><td>{{ $p->telefono }}</td><td>{{ $p->direccion }}</td>
          <td><a href="{{ route('admin.proveedores.edit', $p) }}" class="ib ib-edit"><i class="fas fa-pencil-alt"></i></a></td>
          <td>@include('partials.borrar', ['ruta' => route('admin.proveedores.destroy', $p), 'msg' => '¿Eliminar a este proveedor?'])</td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:var(--muted)">Aún no hay proveedores</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
