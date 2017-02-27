
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
    <table class="table table-striped table-hover tabla-media">
        <thead class="bg-primary">
            <tr>
                {*                <th>id</th>*}
                <th>Nombre</th>
                <th class="text-right">
                    <a class="btn btn-primary btn-round" title="Crear nuevo" href="{$_layoutParams.root}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                        {*                        <a class="btn btn-primary" href="{$_layoutParams.root}{$controlador}/nuevo">Nuevo</a>*}
                </th>
            </tr>
        </thead>
        {foreach item=item from=$datos}
            <tr>
                {*                <td>{$item.id}</td>*}
                <td>{$item.nombre}</td>
                <td style="text-align: right">
                    {if Session::accesoViewEstricto(array('especial'))}
                        <a title="Editar" class="btn btn-default btn-sm" href="{$_layoutParams.root}{$controlador}/editar/{$item.id}/{$pagina}"><span class=" glyphicon glyphicon-pencil"></span></a>
                        {/if}
                        {if Session::accesoViewEstricto(array('especial'))}
                            {*            <a title="Eliminar" class="btn btn-danger btn-sm" href="{$_layoutParams.root}{$controlador}/eliminar/{$item.id}/{$pagina}"><span class=" glyphicon glyphicon-trash"></span></a>*}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{$_layoutParams.root}{$controlador}/eliminar/{$item.id}/{$pagina}" 
                            data-nombre="{$item.nombre}"
                            data-tabla="{$titulo}"
                            title="Borrar {$titulo}">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                    {/if}
                </td>

            </tr>
        {/foreach}
    </table>
{else}
    <div class="alert alert-warning" style="padding-top: 250px;">
        No hay datos!!!!!!
    </div>
{/if}
{if ($paginas==1)}
    {$paginacion}
{/if}





<!--modal confirmar borrado -->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="titulo-modal" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-10 col-md-push-1">
                    ¿Desea borrar <span id="nombre" class="text-primary"></span> 
                    de la tabla de  <span id="tabla" class="text-primary"></span>?
                </div>
                <div class="row"></div>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

