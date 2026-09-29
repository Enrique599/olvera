@extends('layouts.admin')

@section('titulo', 'Validación de Pago')

@section('contenido')
<div class="ptitle">Validación de Pago</div>
<div class="psub">{{ $saludo }} — Gestiona y valida el estado de pago de las ventas</div>

<div class="stat-grid" style="margin-bottom:20px">
  <div class="sc sc-green"><div><div class="sc-val">{{ $stats['pagados'] }}</div><div class="sc-lbl">Pagados</div></div><i class="fas fa-check-circle sc-icon"></i></div>
  <div class="sc sc-amber"><div><div class="sc-val">{{ $stats['pendientes'] }}</div><div class="sc-lbl">Pendientes</div></div><i class="fas fa-clock sc-icon"></i></div>
  <div class="sc sc-teal"><div><div class="sc-val">{{ $stats['parciales'] }}</div><div class="sc-lbl">Pago parcial</div></div><i class="fas fa-adjust sc-icon"></i></div>
  <div class="sc sc-red"><div><div class="sc-val">${{ number_format($stats['monto'], 2) }}</div><div class="sc-lbl">Monto pendiente</div></div><i class="fas fa-dollar-sign sc-icon"></i></div>
</div>

<div class="tcard">
  <div class="tcard-hdr"><div class="tcard-ttl"><i class="fas fa-money-check-dollar" style="color:var(--accent)"></i> Ventas — Estado de pago</div></div>
  <table>
    <thead><tr><th>ID</th><th>Cliente</th><th>Fecha</th><th>Total</th><th>Método</th><th>Estado pago</th><th>Validar</th></tr></thead>
    <tbody>
      @forelse ($ventas as $v)
        @php [$etiqueta, $color] = \App\Models\Venta::BADGES_PAGO[$v->estado_pago] ?? [$v->estado_pago, '#7a8099']; @endphp
        <tr>
          <td>#{{ $v->id }}</td><td>{{ $v->cliente->nombre_completo }}</td><td>{{ $v->fecha->format('Y-m-d') }}</td>
          <td><strong>${{ number_format($v->total, 2) }}</strong></td><td>{{ $v->metodo_pago ?? '—' }}</td>
          <td><span class="pago-badge" style="background:{{ $color }}22;color:{{ $color }}">{{ $etiqueta }}</span></td>
          <td><button type="button" class="btn btn-sm btn-primary" onclick='abrirModal(@json($v->id), @json($v->estado_pago), @json($v->metodo_pago ?? "EFECTIVO"), @json($v->notas_pago ?? ""))'><i class="fas fa-pen"></i> Validar</button></td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:var(--muted)">Aún no hay ventas</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="modal-overlay" id="modalOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center">
  <div class="modal-box" style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:32px;min-width:380px;max-width:480px">
    <div class="modal-title" style="font-size:18px;font-weight:700;color:var(--text);margin-bottom:20px"><i class="fas fa-money-check-dollar" style="color:var(--accent)"></i> Validar pago — Venta #<span id="modalId"></span></div>
    <form id="formPago" action="#" method="post">
      @csrf
      @method('PUT')
      <div class="fg" style="margin-bottom:14px"><label>Estado del pago</label>
        <select class="fc" id="modalEstado" name="estado_pago">
          <option value="PENDIENTE">⏳ Pendiente</option><option value="PAGADO">✅ Pagado</option>
          <option value="PARCIAL">🔶 Pago parcial</option><option value="CANCELADO">❌ Cancelado</option>
        </select></div>
      <div class="fg" style="margin-bottom:14px"><label>Método de pago</label>
        <select class="fc" id="modalMetodo" name="metodo_pago">
          <option value="EFECTIVO">💵 Efectivo</option><option value="TRANSFERENCIA">🏦 Transferencia</option>
          <option value="TARJETA">💳 Tarjeta</option><option value="CHEQUE">📄 Cheque</option>
        </select></div>
      <div class="fg" style="margin-bottom:18px"><label>Notas (opcional)</label><input class="fc" type="text" id="modalNotas" name="notas_pago" placeholder="Referencia, folio, etc."></div>
      <div style="display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        <button type="button" class="btn btn-outline" onclick="cerrarModal()">Cancelar</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
const urlPago = @json(url('admin/validacion-pago')) + '/';
function abrirModal(id, estado, metodo, notas) {
  document.getElementById('modalId').textContent = id;
  document.getElementById('formPago').action = urlPago + id;
  document.getElementById('modalEstado').value = estado;
  document.getElementById('modalMetodo').value = metodo;
  document.getElementById('modalNotas').value = notas;
  document.getElementById('modalOverlay').style.display = 'flex';
}
function cerrarModal(){ document.getElementById('modalOverlay').style.display = 'none'; }
document.getElementById('modalOverlay').addEventListener('click', function(e){ if(e.target === this) cerrarModal(); });
</script>
@endpush
