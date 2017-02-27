
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
{if isset($posts) && count($posts)}
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th></th>
{*                <th>Usuario</th>*}
                <th>Nombre</th>
                <th>e-mail</th>
                <th>Tel&eacute;fono</th>
                <th>Centro</th>
                    {if Session::accesoView('especial')}
                    <th>&Uacute;ltimo acceso</th>
                    {/if}
                <th class="text-center">
                    {if Session::accesoView('especial')}
                        <a class="btn btn-primary btn-round" title="Crear nuevo" href="{BASE_URL}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                        {/if}
                </th>
            </tr>
        </thead>
        {foreach item=post from=$posts}

            <tr 
                {if ($post.estado=="0")}
                    class="text-muted" style='font-style: italic'
                {/if}
                >
                <td style="text-align: center;">
                    {if ($post.role== 'usuario')} 
                        {assign var="role" value="<span title='usuario' class='text-primary'>"}
                    {elseif ($post.role== 'admin')} 
                        {assign var="role" value="<span title='admin' class='text-danger'>"}
                    {elseif ($post.role== 'especial')} 
                        {assign var="role" value="<span title='especial' class='text-success'>"}
                    {else} 
                        {assign var="role" value="<span title='error' class='text-info'>"}
                    {/if}
                    {$role}<i class="glyphicon glyphicon-user"></i></span>
                {*{$post.usuario}*}</td>
                <td>{$post.nombre}</td>
                <td>{$post.email}</td>
                <td>{$post.telefono}</td>
                <td>{$post.centro|default:'<em class="text-info">Sin centro asignado</em>'}</td>
                    {if Session::accesoView('especial')}
                    <td>{$post.ultimo_acceso}</td>
                    {/if}
                <td class="text-center">
                    {if Session::accesoViewEstricto(array('especial'))}
                        <a class="btn btn-default btn-round" title="Editar datos de dinamizador" href="{BASE_URL}dinamizador/editar/{$post.id}"><span class=" glyphicon glyphicon-pencil"></span></a>
                        {/if}
                        {if Session::accesoViewEstricto(array('especial'))}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}dinamizador/eliminar/{$post.id}" 
                            data-alumno="{$post.nombre}"
                            title="Borrar dinamizador">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                    {/if}
                </td>
            </tr>
        {/foreach}
    </table>
    <hr>
{else}
    <div class="alert alert-warning">
        No hay datos!!
    </div>
{/if}
{$paginacion}

<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el registro correspondiente a <strong><span id="nombre-alumno" class="text-primary"></span></strong> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

