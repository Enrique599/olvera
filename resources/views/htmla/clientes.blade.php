@extends('layouts.admin')

@section('titulo', 'Registro de Clientes')

@section('contenido')
<div class="ptitle">Registro de Clientes</div>
<div class="psub">{{ $saludo }}</div>

<div class="fcard">
  <form action="{{ $registro ? route('admin.clientes.update', $registro) : route('admin.clientes.store') }}" method="post">
    @csrf
    @if ($registro) @method('PUT') @endif
    <div class="fgrid">
      <div class="fg"><label>Nombre *</label><input class="fc" type="text" name="nombre" value="{{ old('nombre', $registro?->nombre) }}" placeholder="Nombre" required></div>
      <div class="fg"><label>Apellido Paterno *</label><input class="fc" type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $registro?->apellido_paterno) }}" placeholder="Apellido Paterno" required></div>
      <div class="fg"><label>Teléfono *</label><input class="fc" type="text" name="telefono" value="{{ old('telefono', $registro?->telefono) }}" placeholder="10 dígitos" maxlength="10" required></div>
      <div class="fg"><label>Contraseña {{ $registro ? '(vacía = no cambiar)' : '*' }}</label><input class="fc" type="password" name="contrasena" placeholder="Contraseña" @required(! $registro)></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ $registro ? 'Actualizar' : 'Guardar' }}</button>
    @if ($registro)
      <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline">Cancelar</a>
    @endif
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-users" style="color:var(--accent)"></i> Lista de Clientes</div></div>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Ap. Paterno</th><th>Teléfono</th><th>Eliminar</th><th>Modificar</th></tr></thead>
    <tbody>
      @forelse ($clientes as $c)
        <tr>
          <td>{{ $c->id }}</td><td>{{ $c->nombre }}</td><td>{{ $c->apellido_paterno }}</td><td>{{ $c->telefono }}</td>
          <td>@include('partials.borrar', ['ruta' => route('admin.clientes.destroy', $c), 'msg' => '¿Eliminar a este cliente?'])</td>
          <td><a href="{{ route('admin.clientes.edit', $c) }}" class="ib ib-edit"><i class="fas fa-pencil-alt"></i></a></td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:var(--muted)">Aún no hay clientes</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
