@extends('layouts.admin')

@section('titulo', 'Inventario')

@section('contenido')
<div class="ptitle">Inventario</div>
<div class="psub">{{ $saludo }} — Visualización del inventario actual</div>

<div class="stat-grid" style="margin-bottom:20px">
  <div class="sc sc-teal"><div><div class="sc-val">{{ $stats['productos'] }}</div><div class="sc-lbl">Productos distintos</div></div><i class="fas fa-boxes sc-icon"></i></div>
  <div class="sc sc-green"><div><div class="sc-val">{{ $stats['unidades'] }}</div><div class="sc-lbl">Unidades totales</div></div><i class="fas fa-warehouse sc-icon"></i></div>
  <div class="sc sc-amber"><div><div class="sc-val">${{ number_format($stats['valor'], 2) }}</div><div class="sc-lbl">Valor del inventario</div></div><i class="fas fa-dollar-sign sc-icon"></i></div>
  <div class="sc sc-red"><div><div class="sc-val">{{ $stats['bajo'] }}</div><div class="sc-lbl">Stock bajo (&lt;{{ \App\Models\Producto::STOCK_BAJO }})</div></div><i class="fas fa-exclamation-triangle sc-icon"></i></div>
</div>

<div class="tcard">
  <div class="tcard-hdr">
    <div class="tcard-ttl"><i class="fas fa-warehouse" style="color:var(--accent3)"></i> Estado del inventario</div>
    <small style="color:var(--muted)">Ordenado: menor stock primero</small>
  </div>
  <table>
    <thead><tr><th>ID</th><th>Producto</th><th>Categoría</th><th>Stock actual</th><th>Nivel</th><th>Precio venta</th><th>Valor stock</th><th>Ajustar</th></tr></thead>
    <tbody>
      @forelse ($productos as $p)
        @php [$etiqueta, $color] = $p->nivel_stock; @endphp
        <tr>
          <td>{{ $p->id }}</td><td><strong>{{ $p->nombre }}</strong></td><td>{{ $p->categoria->nombre }}</td>
          <td><span style="font-size:18px;font-weight:800;color:{{ $color }}">{{ $p->stock }}</span></td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700">{{ $etiqueta }}</span></td>
          <td>${{ number_format($p->precio_venta, 2) }}</td><td>${{ number_format($p->valor_stock, 2) }}</td>
          <td>
            <form action="{{ route('admin.inventario.update', $p) }}" method="post" style="display:flex;gap:6px;align-items:center">
              @csrf
              @method('PUT')
              <input class="fc" type="number" name="stock" value="{{ $p->stock }}" min="0" style="width:70px;padding:5px 8px;font-size:13px">
              <button type="submit" class="btn btn-sm btn-primary" title="Guardar stock"><i class="fas fa-save"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">No hay productos en inventario</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
