
{if isset($actividades) && count($actividades)}
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr >
                <th></th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Responsable</th>
                <th class="hidden-xs">Fechas</th>
                <th class="hidden-xs">Horario</th>
                <th class="text-center">
                    <a class="btn btn-warning btn-sm" title="Crear nuevo" href="{BASE_URL}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i>&nbsp; Nueva actividad</a>
                </th>
            </tr>
        </thead>
        {foreach item=item from=$actividades}
            <tr>
                <td class="text-info small">{$item.row}</td>
                <td>{$item.tipo_actividad}</td>
                <td 
                    {if $item.nombre_elipsis != $item.nombre}
                        title="{$item.nombre}"
                    {/if}
                    >
                    {$item.nombre_elipsis}
                </td>
                <td>{$item.responsable}</td>
                <td class="hidden-xs">{$item.fechas}</td>
                <td class="hidden-xs">{$item.horas}</td>
                <td class="text-center">
                    <a class="btn btn-info btn-round" href="{BASE_URL}{$controlador}/ver/{$item.id}" title="Ver ficha"><i class="glyphicon glyphicon-eye-open"></i></a>
                        {if Session::accesoViewEstricto(array('aula_innova','especial'))}
                        <a title="Editar actividad" class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$item.id}">
                            <span class=" glyphicon glyphicon-pencil"></span>
                        </a>
                    {/if}
                    {if Session::accesoViewEstricto(array('aula_innova','especial'))}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}{$controlador}/eliminar/{$item.id}" 
                            data-curso="{$item.nombre}"
                            title="Borrar actividad">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                    {/if}
                    <a title="Inscribir usuarios" class="btn btn-suave btn-round" href="{BASE_URL}{$controlador}/inscribir/{$item.id}">
                        <span class=" glyphicon glyphicon-list"></span>
                    </a>
                </td>
            </tr>
        {/foreach}
    </table>
    {$paginacion}
{else}
    <div class="alert alert-info text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay datos que mostrar
    </div>
{/if}
<hr/>




<!--modal confirmar borrar curso-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el curso <span id="curso" class="text-primary"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>