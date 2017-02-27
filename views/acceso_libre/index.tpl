
{if isset($_error)}
    <!--Mensajes privados de cada controlador-->
    <div class="row">
        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <h3>Atenci&oacute;n</h3> <hr> 
            {$_error}
        </div>
    </div>
{/if}

{if isset($_mensaje)}
    <!--Mensajes privados de cada controlador-->
    <div class="row">
        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <div class="text-center">
                {$_mensaje}
            </div>
        </div>
    </div>
{/if}

<form role="form" class="form-horizontal " action="" method="post">    
    <div class="col-md-4 pull-right">
        <div class="form-group">
            <label for="centro" class="col-md-2 control-label">Centro:</label>
            <div class="col-md-10">
                <select class='form-control' name="centro" onchange="this.form.submit()">
                    {foreach from=$centros item=item}
                        {if ($centro == $item.id)}
                            <option value='{$item.id}' selected>{$item.nombre}</option>
                        {else}
                            <option value='{$item.id}' >{$item.nombre}</option>
                        {/if}
                    {/foreach}
                </select>
            </div>
        </div>
    </div>
</form>
{if isset($datos) && count($datos)}

    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th></th>
                <th>Centro</th>
                <th>Puesto</th>
                <th>DNI/NIE</th>
                <th>Nombre</th>
                <th class="text-center">Inicio</th>
                <th class="text-center">Duraci&oacute;n</th>
                <th class="text-center">
                    {if ($centro!=0)}
                        <a class="btn btn-primary btn-round"
                           title="Crear nueva sesión" 
                           href="{BASE_URL}{$controlador}/nuevo/{$centro}">
                            <i class="glyphicon glyphicon-plus"></i>
                        </a>
                    {/if}
                    <a 
                        class="btn btn-danger btn-round"
                        href="#" 
                        data-toggle="modal" 
                        data-target="#confirmar-cerrar-todas" 
                        data-href="{BASE_URL}{$controlador}/cerrarTodas/{$centro}" 
                        data-centro="{$nombre_centro}"
                        title="Finalizar todas las sesiones">
                        <i class=" glyphicon glyphicon-time"></i>
                    </a>
                    {if Session::accesoView('especial')}
                        <a 
                            class="btn btn-warning btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-cerrar-antiguas" 
                            data-href="{BASE_URL}{$controlador}/cerrarSesionesAnteriores/{$centro}" 
                            data-centro-antiguas="{$nombre_centro}"
                            title="Finalizar las sesiones antiguas">
                            <i class=" glyphicon glyphicon-remove"></i>
                        </a> 
                    {/if}
                </th>
            </tr>
        </thead>
        {foreach item=item from=$datos}
            <tr>
                <td class="text-info small">{$item.row}</td>
                <td>{$item.centro}</td>
                <td>{$item.equipo}</td>
                <td>{$item.dni}</td>
                <td>{$item.nombre}</td>
                <td class="text-center">{$item.fecha_inicio}</td>
                <td  class="text-center" title = "{$item.fecha_fin|default:''}">{$item.delta|default:$item.fecha_fin}</td>
                <td class="text-center">

                    {if Session::accesoView('especial')}
                        <a class="btn btn-primary btn-round" title="Editar" href="{BASE_URL}{$controlador}/editar"><i class="glyphicon glyphicon-pencil"></i></a>
                        {/if}
                        {if !isset($item.fecha_fin)}
                        <a 
                            class="btn btn-warning btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}{$controlador}/finalizar/{$item.id}" 
                            data-nombre="{$item.nombre}"
                            title="Finalizar sesión">
                            <i class=" glyphicon glyphicon-time"></i>
                        </a>
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


<!--modal confirmar borrar-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="titulo-modal" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea finalizar la sesi&oacute;n de <span id="nombre" class="text-primary"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-warning btn-ok">Finalizar sesi&oacute;n</a>
            </div>
        </div>
    </div>
</div>


<!--modal confirmar cerrar todas las sesiones-->
<div class="modal fade" id="confirmar-cerrar-todas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="titulo-modal-cerrar-todas" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea finalizar TODAS  las sesiones de acceso libre en <span id="centro" class="text-primary"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Finalizar TODAS las sesiones</a>
            </div>
        </div>
    </div>
</div>

<!--modal confirmar cerrar las sesiones antiguas-->
<div class="modal fade" id="confirmar-cerrar-antiguas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="titulo-modal-cerrar-antiguas" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea finalizar TODAS  las sesiones antiguas en <span id="centro-antiguas" class="text-primary"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Finalizar las sesiones antiguas</a>
            </div>
        </div>
    </div>
</div>

