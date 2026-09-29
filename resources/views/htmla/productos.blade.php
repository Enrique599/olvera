@extends('layouts.admin')

@section('titulo', 'Productos')

@section('contenido')
<div class="ptitle">Productos</div>
<div class="psub">{{ $saludo }} — Catálogo y registro de productos</div>

<div class="stat-grid" style="margin-bottom:20px">
  <div class="sc sc-teal"><div><div class="sc-val">{{ $stats['productos'] }}</div><div class="sc-lbl">Productos registrados</div></div><i class="fas fa-box-open sc-icon"></i></div>
  <div class="sc sc-amber"><div><div class="sc-val">{{ $stats['unidades'] }}</div><div class="sc-lbl">Unidades en stock total</div></div><i class="fas fa-warehouse sc-icon"></i></div>
  <div class="sc sc-red"><div><div class="sc-val">{{ $stats['bajo'] }}</div><div class="sc-lbl">Stock bajo (&lt;{{ \App\Models\Producto::STOCK_BAJO }})</div></div><i class="fas fa-exclamation-triangle sc-icon"></i></div>
</div>

<div class="fcard" style="margin-bottom:20px">
  <div style="font-size:14px;font-weight:700;color:var(--text);margin-bottom:14px"><i class="fas fa-plus-circle" style="color:var(--accent)"></i> Agregar nuevo producto</div>
  <form action="{{ route('admin.productos.store') }}" method="post">
    @csrf
    <div class="fgrid">
      <div class="fg"><label>Nombre del producto *</label><input class="fc" type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required></div>
      <div class="fg"><label>Stock inicial *</label><input class="fc" type="number" name="stock" value="{{ old('stock') }}" min="0" placeholder="0" required></div>
      <div class="fg"><label>Categoría *</label>
        <select class="fc" name="categoria_id" required>
          <option value="">— Categoría —</option>
          @foreach ($categorias as $cat)
            <option value="{{ $cat->id }}" @selected((int) old('categoria_id') === $cat->id)>{{ $cat->nombre }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>Precio proveedor ($) *</label><input class="fc" type="number" name="precio_proveedor" value="{{ old('precio_proveedor') }}" step="0.01" min="0" placeholder="0.00" required></div>
      <div class="fg"><label>Precio neto / venta ($) *</label><input class="fc" type="number" name="precio_venta" value="{{ old('precio_venta') }}" step="0.01" min="0" placeholder="0.00" required></div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar producto</button>
  </form>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-box-open" style="color:var(--accent)"></i> Catálogo de Productos</div></div>
  <table>
    <thead><tr><th>ID</th><th>Nombre</th><th>Categoría</th><th>Stock</th><th>Precio proveedor</th><th>Precio venta</th><th>Margen</th><th>Eliminar</th></tr></thead>
    <tbody>
      @forelse ($productos as $p)
        @php $color = $p->stock === 0 ? '#ef4444' : ($p->stock < \App\Models\Producto::STOCK_BAJO ? '#f97316' : '#22c55e'); @endphp
        <tr>
          <td>{{ $p->id }}</td><td><strong>{{ $p->nombre }}</strong></td><td>{{ $p->categoria->nombre }}</td>
          <td><span style="background:{{ $color }}22;color:{{ $color }};padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700">{{ $p->stock }} uds</span></td>
          <td>${{ number_format($p->precio_proveedor, 2) }}</td><td>${{ number_format($p->precio_venta, 2) }}</td>
          <td><span style="color:{{ $p->margen >= 0 ? '#22c55e' : '#ef4444' }};font-weight:700">{{ $p->margen >= 0 ? '+' : '-' }}${{ number_format(abs($p->margen), 2) }} <small style="opacity:.7">({{ $p->margen_porcentaje }}%)</small></span></td>
          <td>@include('partials.borrar', ['ruta' => route('admin.productos.destroy', $p), 'msg' => '¿Eliminar este producto?'])</td>
        </tr>
      @empty
        <tr><td colspan="8" style="text-align:center;color:var(--muted)">Aún no hay productos</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
