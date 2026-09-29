@extends('layouts.admin')

@section('titulo', 'Restaurar Base de Datos')

@section('contenido')
<div class="ptitle">Restaurar Base de Datos</div>
<div class="psub">Importa un archivo .sql para restaurar los datos</div>

<div class="alert alert-warn" style="margin-bottom:18px">
  <i class="fas fa-exclamation-triangle"></i>
  <strong>Advertencia:</strong> Esta acción sobreescribirá los datos actuales. No se puede deshacer.
</div>

<div class="fcard" style="max-width:500px">
  <form action="{{ route('admin.restaurar.subir') }}" method="post" enctype="multipart/form-data" onsubmit="return confirm('Se sobreescribirán los datos actuales. ¿Continuar?')">
    @csrf
    <div class="fg" style="margin-bottom:16px">
      <label>Selecciona un archivo .sql</label>
      <input class="fc" type="file" name="archivo" accept=".sql" required>
    </div>
    <div style="display:flex;gap:10px">
      <button type="submit" class="btn btn-orange"><i class="fas fa-upload"></i> Restaurar</button>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Cancelar</a>
    </div>
  </form>
</div>
@endsection
