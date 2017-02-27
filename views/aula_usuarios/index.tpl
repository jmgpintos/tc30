
{if isset($datos) && count($datos)}
    {if isset($controlador)}
        <div class="visible-xs pull-right text-right">
            <form class="navbar-form" role="form" method='post' action='{BASE_URL}{$controlador}/buscar'>
                <div class="input-group" title="Buscar por telefono, DNI, nombre o apellidos">
                    <input type="text" class="form-control" placeholder="Buscar" name="busqueda">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-suave" type="submit" ><i class="glyphicon glyphicon-search"></i></button>
                            {if $es_busqueda}
                                {*                                <a href="{BASE_URL}{$controlador}/index" class="btn btn-default btn-suave" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>*}
                            <a href="{BASE_URL}{$controlador}/ver_todo" class="btn btn-danger" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>
                            {/if}
                    </div>
                </div>
            </form>
        </div>
    {/if}
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr >
                <th></th>
                <th>NIF/NIE</th>
                <th>Nombre</th>
                <th class="hidden-xs">Tel&eacute;fono</th>
                <th class="hidden-xs">e-mail</th>
                <th class="text-center">
                    {if isset($controlador)}
            <div class="hidden-xs pull-right text-right">
                <form class="navbar-form" role="form" method='post' action='{BASE_URL}{$controlador}/buscar'>
                    <div class="input-group" title="Buscar por telefono, DNI, nombre o apellidos">
                        <input type="text" class="form-control" placeholder="Buscar" name="busqueda">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-suave" type="submit" ><i class="glyphicon glyphicon-search"></i></button>
                                {if $es_busqueda}
                                    {*                                <a href="{BASE_URL}{$controlador}/index" class="btn btn-default btn-suave" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>*}
                                <a href="{BASE_URL}{$controlador}/ver_todo" class="btn btn-danger" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>
                                {/if}
                        </div>
                    </div>
                </form>
            </div>
        {/if}
        {*{if Session::accesoView('especial')}
        <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}alumno/nuevo">Crear nuevo </a>
        <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}alumno/nuevo_auto">Auto </a>
        {/if}*}
    </th>
</tr>
</thead>
{foreach item=item from=$datos}
    <tr>
        <td class="text-info small">{$item.row}</td>
        <td>{$item.dni}</td>
        <td>
            {if $item.sexo=='H'}
                <i class='fa fa-male fa-fw' title="Hombre"></i>
            {else}
                <i class="fa fa-female fa-fw" title="Mujer"></i>
            {/if}
            {$item.nombre}
        </td>
        <td class="hidden-xs">{$item.telefono}</td>
        <td class="hidden-xs">{$item.email}</td>
        <td class="text-center">
            <a href="index.phtml"></a>
            {*            {if Session::accesoViewEstricto(array('especial'))}*}
            <a class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$item.id}" title="Ver ficha del alumno"><span class=" glyphicon glyphicon-eye-open"></span></a>
                {*                {/if}*}
                {*                {if Session::accesoViewEstricto(array('especial'))}*}
            <a class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$item.id}" title="Editar datos del alumno"><span class=" glyphicon glyphicon-pencil"></span></a>
                {*                {/if}*}
                <a 
                    class="btn btn-danger btn-round"
                    href="#" 
                    data-toggle="modal" 
                    data-target="#confirmar-borrar" 
                    data-href="{BASE_URL}{$controlador}/eliminar/{$item.id}" 
                    data-alumno="{$item.nombre}"
                    title="Borrar usuario">
                    <i class=" glyphicon glyphicon-trash"></i>
                </a>
                {*                <a class="btn btn-danger btn-round" href="{BASE_URL}{$controlador}/eliminar/{$item.id}" title="Borrar alumno"><span class=" glyphicon glyphicon-trash"></span></a>*}
        </td>
    </tr>
{/foreach}
</table>
{$paginacion}
{else}
    {* <!-- Modal -->
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
    <a href ="javascript:history.back()" class="btn btn-default" data-dismiss="modal">Volver</a>
    </div>
    </div>

    </div>
    </div>
    <script type='text/javascript'>
    $("#myModal").modal('show');
    </script>*}
    <div class="col-md-4 col-md-push-4 alert alert-warning text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay resultados<hr/>
        <a href ="{BASE_URL}{$controlador}/index" class="btn btn-warning form-control" >Volver</a>
    </div>
{/if}





<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el registro correspondiente a <span id="nombre-alumno" class="text-primary"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

