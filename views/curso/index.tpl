
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
{if isset($datos) && count($datos)}
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Categor&iacute;a</th>
                <th class="text-center">
                    {if Session::accesoView('especial')}
                        <a class="btn btn-primary btn-round" title="Crear nuevo" href="{BASE_URL}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                            {*                    <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}alumno/nuevo_auto">Auto </a>*}
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
                <td style="text-align: center;">
                    {if ($item.especial==1)}
                        <i class="glyphicon glyphicon-asterisk text-danger" title="Especial, no se cuenta para estadísticas"></i>
                    {/if}
                </td>
                <td>{$item.nombre}</td>
                <td>{$item.categoria}</td>
                <td class="text-center">
                    <a href="index.phtml"></a>
                    {*            {if Session::accesoViewEstricto(array('especial'))}*}
                    <a class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$item.id}" title="Ver ficha del curso"><span class=" glyphicon glyphicon-eye-open"></span></a>
                        {*                {/if}*}
                        {if Session::accesoViewEstricto(array('especial'))}
                        <a class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$item.id}" title="Editar datos del curso"><span class=" glyphicon glyphicon-pencil"></span></a>
{*                        <a class="btn btn-danger btn-round" href="{BASE_URL}{$controlador}/eliminar/{$item.id}" title="Borrar curso"><span class=" glyphicon glyphicon-trash"></span></a>*}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}{$controlador}/eliminar/{$item.id}" 
                            data-alumno="{$item.nombre}"
                            title="Borrar curso">
                            <i class=" glyphicon glyphicon-trash"></i>
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



<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="titulo-modal" class="modal-title"></h4>
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

