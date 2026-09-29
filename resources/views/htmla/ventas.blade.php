@extends('layouts.admin')

@section('titulo', 'Registro de Ventas')

@section('contenido')
<div class="ptitle">Registro de Ventas</div>
<div class="psub">Registra y consulta las ventas realizadas</div>

<div class="fcard">
  <form action="{{ $registro ? route('admin.ventas.update', $registro) : route('admin.ventas.store') }}" method="post">
    @csrf
    @if ($registro) @method('PUT') @endif
    <div class="fgrid">
      <div class="fg"><label>Fecha *</label><input class="fc" type="date" name="fecha" value="{{ old('fecha', $registro?->fecha->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Realización *</label><input class="fc" type="text" name="realizacion" value="{{ old('realizacion', $registro?->realizacion) }}" placeholder="Descripción" required></div>
      <div class="fg"><label>Total ($) *</label><input class="fc" type="number" name="total" value="{{ old('total', $registro?->total) }}" step="0.01" min="0" placeholder="0.00" required></div>
      <div class="fg"><label>Cliente *</label>
        <select class="fc" name="cliente_id" required>
          <option value="">-- Selecciona Cliente --</option>
          @foreach ($clientes as $c)
            <option value="{{ $c->id }}" @selected((int) old('cliente_id', $registro?->cliente_id) === $c->id)>{{ $c->id }} - {{ $c->nombre_completo }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Total Piezas *</label><input class="fc" type="number" name="total_piezas" value="{{ old('total_piezas', $registro?->total_piezas) }}" min="1" placeholder="0" required></div>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> {{ $registro ? 'Actualizar Venta' : 'Guardar Venta' }}</button>
    @if ($registro)
      <a href="{{ route('admin.ventas.index') }}" class="btn btn-outline">Cancelar</a>
    @endif
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-list" style="color:var(--green)"></i> Lista de Ventas</div></div>
  <table>
    <thead><tr><th>ID Venta</th><th>Fecha</th><th>Realización</th><th>Total</th><th>Cliente</th><th>Total Piezas</th><th>Eliminar</th><th>Modificar</th></tr></thead>
    <tbody>
      @forelse ($ventas as $v)
        <tr>
          <td>#{{ $v->id }}</td><td>{{ $v->fecha->format('Y-m-d') }}</td><td>{{ $v->realizacion }}</td>
          <td>${{ number_format($v->total, 2) }}</td><td>{{ $v->cliente->nombre_completo }}</td><td>{{ $v->total_piezas }}</td>
          <td>@include('partials.borrar', ['ruta' => route('admin.ventas.destroy', $v), 'msg' => '¿Eliminar esta venta?'])</td>
          <td><a href="{{ route('admin.ventas.edit', $v) }}" class="ib ib-edit"><i class="fas fa-pencil-alt"></i></a></td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">Aún no hay ventas</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
