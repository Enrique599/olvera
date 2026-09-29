<form action="{{ $ruta }}" method="post" style="display:inline" onsubmit="return confirm('{{ $msg ?? '¿Eliminar este registro?' }}')">
  @csrf
  @method('DELETE')
  <button type="submit" class="ib ib-del" title="Eliminar"><i class="fas fa-times"></i></button>
</form>
