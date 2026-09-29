@extends('layouts.admin')

@section('titulo', 'Usuarios / Empleados')

@section('contenido')
<div class="ptitle">Usuarios / Empleados</div>
<div class="psub">{{ $saludo }} — Gestiona los accesos al sistema</div>

<div class="fcard" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px"><i class="fas fa-user-plus" style="color:var(--accent2)"></i> {{ $registro ? 'Editar usuario/empleado' : 'Registrar nuevo usuario/empleado' }}</div>
  <form action="{{ $registro ? route('admin.usuarios.update', $registro) : route('admin.usuarios.store') }}" method="post">
    @csrf
    @if ($registro) @method('PUT') @endif
    <div class="fgrid">
      <div class="fg"><label>Nombre *</label><input class="fc" type="text" name="nombre" value="{{ old('nombre', $registro?->nombre) }}" placeholder="Nombre" required></div>
      <div class="fg"><label>Apellido Paterno *</label><input class="fc" type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $registro?->apellido_paterno) }}" placeholder="Apellido" required></div>
      <div class="fg"><label>Teléfono *</label><input class="fc" type="text" name="telefono" value="{{ old('telefono', $registro?->telefono) }}" placeholder="10 dígitos" maxlength="10" required></div>
      <div class="fg"><label>Dirección *</label><input class="fc" type="text" name="direccion" value="{{ old('direccion', $registro?->direccion) }}" placeholder="Dirección" required></div>
      <div class="fg"><label>Contraseña {{ $registro ? '(vacía = no cambiar)' : '* (mín. 6 car.)' }}</label><input class="fc" type="password" name="contrasena" placeholder="••••••••" @required(! $registro)></div>
      <div class="fg"><label>Rol *</label>
        <select class="fc" name="rol" required>
          @foreach ($roles as $valor => $etiqueta)
            <option value="{{ $valor }}" @selected(old('rol', $registro?->rol) === $valor)>{{ $etiqueta }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $registro ? 'Actualizar empleado' : 'Guardar empleado' }}</button>
    @if ($registro)
      <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline">Cancelar</a>
    @endif
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-user-gear" style="color:var(--accent2)"></i> Empleados registrados</div></div>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th><th>Dirección</th><th>Rol</th><th>Editar</th><th>Eliminar</th></tr></thead>
    <tbody>
      @forelse ($empleados as $e)
        @php $color = $e->rol === 'admin' ? '#f75e5e' : '#4f8ef7'; @endphp
        <tr>
          <td>{{ $e->id }}</td><td>{{ $e->nombre }}</td><td>{{ $e->apellido_paterno }}</td><td>{{ $e->telefono }}</td><td>{{ $e->direccion }}</td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 12px;border-radius:20px;font-size:11px;font-weight:800;text-transform:uppercase">{{ $e->rol }}</span></td>
          <td><a href="{{ route('admin.usuarios.edit', $e) }}" class="ib ib-edit"><i class="fas fa-pencil-alt"></i></a></td>
          <td>@include('partials.borrar', ['ruta' => route('admin.usuarios.destroy', $e), 'msg' => '¿Eliminar a este empleado?'])</td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">Aún no hay empleados (mientras tanto entras con el acceso por defecto)</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
