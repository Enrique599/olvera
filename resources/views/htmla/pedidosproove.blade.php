@extends('layouts.admin')

@section('titulo', 'Pedidos a Proveedores')

@section('contenido')
<div class="ptitle">Pedidos a Proveedores</div>
<div class="psub">Registro de pedidos realizados a proveedores</div>

<div class="fcard" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px"><i class="fas fa-truck-loading" style="color:var(--accent2)"></i> Registrar pedido a proveedor</div>
  <form action="{{ route('admin.pedidos-proveedores.store') }}" method="post">
    @csrf
    <div class="fgrid">
      <div class="fg"><label>Proveedor *</label>
        <select class="fc" name="proveedor_id" required>
          <option value="">— Selecciona proveedor —</option>
          @foreach ($proveedores as $pr)
            <option value="{{ $pr->id }}" @selected((int) old('proveedor_id') === $pr->id)>{{ $pr->id }} - {{ $pr->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Fecha *</label><input class="fc" type="date" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Total ($) *</label><input class="fc" type="number" name="total" value="{{ old('total') }}" step="0.01" min="0" placeholder="0.00" required></div>
      <div class="fg"><label>Total piezas *</label><input class="fc" type="number" name="total_piezas" value="{{ old('total_piezas') }}" min="1" placeholder="0" required></div>
      <div class="fg"><label>Estado</label>
        <select class="fc" name="estado">
          @foreach (\App\Models\PedidoProveedor::ESTADOS as $estado)
            <option @selected(old('estado') === $estado)>{{ $estado }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar pedido</button>
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-truck-loading" style="color:var(--accent2)"></i> Pedidos realizados</div></div>
  <table>
    <thead><tr><th>ID</th><th>Proveedor</th><th>Teléfono</th><th>Fecha</th><th>Total</th><th>Piezas</th><th>Estado</th><th>Eliminar</th></tr></thead>
    <tbody>
      @forelse ($pedidos as $p)
        @php $color = \App\Models\PedidoProveedor::COLORES[$p->estado] ?? '#7a8099'; @endphp
        <tr>
          <td>#{{ $p->id }}</td><td>{{ $p->proveedor->nombre }}</td><td>{{ $p->proveedor->telefono }}</td><td>{{ $p->fecha->format('Y-m-d') }}</td>
          <td>${{ number_format($p->total, 2) }}</td><td>{{ $p->total_piezas }}</td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 12px;border-radius:20px;font-size:11px;font-weight:800">{{ mb_strtoupper($p->estado) }}</span></td>
          <td>@include('partials.borrar', ['ruta' => route('admin.pedidos-proveedores.destroy', $p), 'msg' => '¿Eliminar este pedido?'])</td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">No hay pedidos a proveedores</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
