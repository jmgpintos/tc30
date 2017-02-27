
{if isset($datos) && count($datos)}
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th>Nombre</th>
                <th class="hidden-xs">Direcci&oacute;n</th>
                <th>Tel&eacute;fono</th>
                <th>Fundaci&oacute;n</th>
                <th class="text-center">
{*                {if isset($controlador)}
                    <div class="pull-right text-right">
                        <form class="navbar-form" role="form" method='post' action='{BASE_URL}{$controlador}/buscar'>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar" name="busqueda">
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-suave" type="submit" title="Buscar"><i class="glyphicon glyphicon-search"></i></button>
                                    {if $es_busqueda}
                                    <a href="{BASE_URL}{$controlador}/index" class="btn btn-default btn-suave" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>
                                    {/if}
                                </div>
                            </div>
                        </form>
                    </div>
                {/if}*}
                {if Session::accesoView('especial')}
                    <a class="btn btn-primary btn-round" title="Crear nuevo" href="{BASE_URL}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
{*                    <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}alumno/nuevo_auto">Auto </a>*}
                {/if}
    </th>
</tr>
</thead>
{foreach item=item from=$datos}
    <tr>
        <td>{$item.nombre}</td>
        <td class="hidden-xs">{$item.direccion}</td>
        <td>{$item.telefono}</td>
        <td>{$item.fundacion}</td>
        {*            <td>{$item.fechaNac}</td>*}
        <td class="text-center">
            <a href="index.phtml"></a>
{*            {if Session::accesoViewEstricto(array('especial'))}*}
                <a class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$item.id}" title="Ver ficha del centro"><span class=" glyphicon glyphicon-eye-open"></span></a>
{*                {/if}*}
                {if Session::accesoViewEstricto(array('especial'))}
                <a class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$item.id}" title="Editar datos del centro"><span class=" glyphicon glyphicon-pencil"></span></a>
                {/if}
                {if Session::accesoViewEstricto(array('admin'))}
                <a class="btn btn-danger btn-round" href="{BASE_URL}{$controlador}/eliminar/{$item.id}" title="Borrar centro"><span class=" glyphicon glyphicon-trash"></span></a>
                {/if}
        </td>
    </tr>
{/foreach}
</table>
{$paginacion}
{else}
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">No hay resultados</h4>
      </div>
      <div class="modal-body">
          <p class="text-warning">La búsqueda no produjo resultados.</p>
      </div>
      <div class="modal-footer">
        <a href ="javascript:history.back()" class="btn btn-default" {*data-dismiss="modal"*}>Volver</a>
      </div>
    </div>

  </div>
</div>
<script >
    $("#myModal").modal('show');
</script>
   {* <div class="col-md-4 col-md-push-4 alert alert-warning text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay resultados
    </div>*}
{/if}