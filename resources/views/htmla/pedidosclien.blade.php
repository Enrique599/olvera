@extends('layouts.admin')

@section('titulo', 'Pedidos de Clientes')

@section('contenido')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;flex-wrap:wrap;gap:10px">
  <div><div class="ptitle">Pedidos de Clientes</div>
  <div class="psub">Ordenados por prioridad — alertas automáticas por tiempo de espera</div></div>
</div>

<div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap">
  <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted)"><span style="width:12px;height:12px;border-radius:50%;background:#ef4444;display:inline-block"></span> Urgente (+7 días)</div>
  <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted)"><span style="width:12px;height:12px;border-radius:50%;background:#f97316;display:inline-block"></span> Alta prioridad (3–6 días)</div>
  <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--muted)"><span style="width:12px;height:12px;border-radius:50%;background:#22c55e;display:inline-block"></span> Normal (0–2 días)</div>
</div>

<div class="fcard" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px"><i class="fas fa-plus-circle" style="color:var(--accent)"></i> Registrar nuevo pedido</div>
  <form action="{{ route('admin.pedidos-clientes.store') }}" method="post">
    @csrf
    <div class="fgrid">
      <div class="fg"><label>Cliente *</label>
        <select class="fc" name="cliente_id" required>
          <option value="">— Selecciona cliente —</option>
          @foreach ($clientes as $c)
            <option value="{{ $c->id }}" @selected((int) old('cliente_id') === $c->id)>{{ $c->id }} - {{ $c->nombre_completo }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Fecha del pedido *</label><input class="fc" type="date" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" required></div>
      <div class="fg"><label>Total ($) *</label><input class="fc" type="number" name="total" value="{{ old('total') }}" step="0.01" min="0" placeholder="0.00" required></div>
      <div class="fg"><label>Total piezas *</label><input class="fc" type="number" name="total_piezas" value="{{ old('total_piezas') }}" min="1" placeholder="0" required></div>
      <div class="fg"><label>Prioridad</label>
        <select class="fc" name="prioridad">
          <option value="NORMAL" @selected(old('prioridad') === 'NORMAL')>Normal</option>
          <option value="ALTA" @selected(old('prioridad') === 'ALTA')>Alta</option>
          <option value="URGENTE" @selected(old('prioridad') === 'URGENTE')>Urgente</option>
        </select>
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar pedido</button>
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-box" style="color:var(--accent)"></i> Lista de Pedidos</div></div>
  <table>
    <thead><tr><th>#</th><th>Cliente</th><th>Teléfono</th><th>Fecha</th><th>Días espera</th><th>Total</th><th>Piezas</th><th>Prioridad</th><th>Acción</th></tr></thead>
    <tbody>
      @forelse ($pedidos as $p)
        @php [$etiqueta, $color] = \App\Models\PedidoCliente::BADGES[$p->prioridad_efectiva]; @endphp
        <tr style="border-left:3px solid {{ $color }}">
          <td>{{ $p->id }}</td><td><strong>{{ $p->cliente->nombre_completo }}</strong></td><td>{{ $p->cliente->telefono }}</td><td>{{ $p->fecha->format('Y-m-d') }}</td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700">{{ $p->dias_espera }} {{ $p->dias_espera === 1 ? 'día' : 'días' }}</span></td>
          <td>${{ number_format($p->total, 2) }}</td><td>{{ $p->total_piezas }}</td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:800;letter-spacing:.5px">{{ $etiqueta }}</span></td>
          <td>@include('partials.borrar', ['ruta' => route('admin.pedidos-clientes.destroy', $p), 'msg' => '¿Eliminar este pedido?'])</td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align:center;color:var(--muted)">No hay pedidos registrados</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
