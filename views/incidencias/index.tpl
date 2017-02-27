
{*{if isset($datos) && count($datos)}*}
    {if isset($controlador)}
        <div class="visible-xs pull-right text-right">
            <form class="navbar-form" role="form" method='post' action='{BASE_URL}{$controlador}/buscar'>
                <div class="input-group" title="Buscar por telefono, DNI, nombre o apellidos">
                    <input type="text" class="form-control" placeholder="Buscar" name="busqueda">
                    <div class="input-group-btn">
                        <button class="btn btn-default btn-suave" type="submit" ><i class="glyphicon glyphicon-search"></i></button>
                            {if $es_busqueda}
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
                <th>Centro</th>
                <th>Equipo</th>
                <th>Tipo</th>
                <th>T&eacute;cnico</th>
                <th>Fecha de creación</th>
                <th class="text-center">Estado  </th>
                <th class="text-center">
                    <a class="btn btn-primary btn-round" 
                       title="Crear nuevo" 
                       href="{BASE_URL}{$controlador}/nuevo">
                        <i class="glyphicon glyphicon-plus"></i>
                    </a>
                </th>
            </tr>
        </thead>
        {foreach item=item from=$datos}
            <tr>
                {*
                
                <th>id_centro</th>
                <th>id_equipo</th>
                <th>Tipo</th>
                <th>Fecha de creación</th>
                <th>Estado  </th>
                *}
                <td class="text-info small">{$item.row}</td>
                <td>{$item.centro}</td>
                <td>{$item.equipo}</td>
                <td>{$item.txt_tipo}</td>
                <td>{$item.tecnico}</td>
                <td>{$item.fecha_creacion}</td>
                <td class="text-center">
                    {if ($item.estado == 1)}
                        <i class="text-success fa fa-2x fa-check-circle" title="cerrada"></i>
                    {else}
                        <i class="text-danger fa fa-2x fa-times-circle" title="abierta"></i>
                    {/if}
                </td>
                <td class="text-center">
                    <a href="index.phtml"></a>
                    {*            {if Session::accesoViewEstricto(array('especial'))}*}
                    <a class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$item.id}" title="Ver ficha de la incidencia"><span class=" glyphicon glyphicon-eye-open"></span></a>
                        {*                {/if}*}
                        {*                {if Session::accesoViewEstricto(array('especial'))}*}
                    <a class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$item.id}" title="Editar ficha de la incidencia"><span class=" glyphicon glyphicon-pencil"></span></a>
                        {*                {/if}*}
                        {if Session::accesoViewEstricto(array('especial'))}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}{$controlador}/eliminar/{$item.id}" 
                            data-centro="{$item.id_centro}"
                            data-equipo="{$item.id_equipo}"
                            data-tipo="{$item.tipo}"
                            data-fecha="{$item.fecha_creacion}"
                            title="Borrar incidencia">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                        {*                <a class="btn btn-danger btn-round" href="{BASE_URL}{$controlador}/eliminar/{$item.id}" title="Borrar alumno"><span class=" glyphicon glyphicon-trash"></span></a>*}
                    {/if}
                </td>
            </tr>
        {/foreach}
    </table>
    {$paginacion}
{*{else}*}
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
    {*<div class="col-md-4 col-md-push-4 alert alert-warning text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay resultados<hr/>
        <a href ="{BASE_URL}{$controlador}/index" class="btn btn-warning form-control" >Volver</a>
    </div>*}
{*{/if}*}





<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar dinamizador</h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar este registro?<br/>
                <div class="row col-md-10 col-md-push-2">
                    Centro: <span id="centro-incidencia" class="text-primary"></span><br/>
                    Equipo: <span id="equipo-incidencia" class="text-primary"></span><br/>
                    Tipo de incidencia: <span id="tipo-incidencia" class="text-primary"></span><br/>
                    Fecha: <span id="fecha-incidencia" class="text-primary"></span>
                </div>
                <div class="row"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

