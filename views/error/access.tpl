
<div class="alert alert-warning col-md-8 col-md-push-2 text-center">
    <h2>
        <span class="glyphicon glyphicon-flash text-danger"></span>
        {$_mensajeerror}
        <span class="glyphicon glyphicon-flash text-danger"></span>
    </h2>
    {$_texto}
<div class="btn-group  btn-group-justified btn-group-sm">
  <a href="{BASE_URL}" class="btn btn-default">Ir al inicio</a>
  <a href="javascript:history.back(1)" class="btn btn-default">Volver a la p&aacute;gina anterior</a>
  {if !Session::get('autenticado')}
  <a href="{BASE_URL}login/index/{$destino}" class="btn btn-default">Iniciar sesi&oacute;n</a>
  {/if}
</div>
</div>

