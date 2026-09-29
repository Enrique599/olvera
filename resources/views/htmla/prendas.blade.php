@extends('layouts.admin')

@section('titulo', 'Registro de Prendas')

@section('contenido')
<div class="ptitle">Registro de Prendas</div>
<div class="psub">{{ $saludo }}</div>

<div class="fcard">
  <form action="{{ $registro ? route('admin.prendas.update', $registro) : route('admin.prendas.store') }}" method="post">
    @csrf
    @if ($registro) @method('PUT') @endif
    <div class="fgrid" style="grid-template-columns:1fr 1fr auto">
      <div class="fg"><label>Nombre de la Prenda *</label><input class="fc" type="text" name="nombre" value="{{ old('nombre', $registro?->nombre) }}" placeholder="Nombre de la prenda" required></div>
      <div class="fg"><label>Número de Piezas *</label><input class="fc" type="number" name="num_piezas" value="{{ old('num_piezas', $registro?->num_piezas) }}" min="0" placeholder="0" required></div>
      <div class="fg" style="justify-content:flex-end"><label>&nbsp;</label>
        <button type="submit" class="btn btn-primary" style="height:42px"><i class="fas fa-save"></i> {{ $registro ? 'Actualizar' : 'Guardar' }}</button>
      </div>
    </div>
    @if ($registro)
      <a href="{{ route('admin.prendas.index') }}" class="btn btn-outline">Cancelar</a>
    @endif
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-tshirt" style="color:var(--accent3)"></i> Lista de Prendas</div></div>
  <table>
    <thead><tr><th>ID</th><th>Prenda</th><th>Núm. Piezas</th><th>Eliminar</th><th>Modificar</th></tr></thead>
    <tbody>
      @forelse ($prendas as $p)
        <tr>
          <td>{{ $p->id }}</td><td>{{ $p->nombre }}</td><td>{{ $p->num_piezas }}</td>
          <td>@include('partials.borrar', ['ruta' => route('admin.prendas.destroy', $p)])</td>
          <td><a href="{{ route('admin.prendas.edit', $p) }}" class="ib ib-edit"><i class="fas fa-pencil-alt"></i></a></td>
        </tr>
      @empty
        <tr><td colspan="5" style="text-align:center;color:var(--muted)">Aún no hay prendas</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
