<div class="col-md-3 well well-lg">

    {include file=$_filtro}
</div>

<div class="col-md-9 pull-right">

    {if isset($datos) && count($datos)}
        <table class="table table-striped table-hover {*table-condensed*}">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Curso</th>
                    <th>Centro</th>
                    <th class="text-center">
                        {if Session::accesoView('especial')}
                            <a class="btn btn-primary btn-round" title="Crear nuevo" href="{BASE_URL}{$controlador}/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                                {*                            <a class="btn btn-primary btn-round" target="_blank" title="Imprimir hojas de cursos" href="{BASE_URL}{$controlador}/HojaCurso"><i class="glyphicon glyphicon-print"></i></a>*}


                            <a 
                                class="btn btn-primary btn-round"
                                href="#" 
                                data-toggle="modal" 
                                data-target="#confirmar-imprimir-hojas-cursos" 
                                data-href="{BASE_URL}{$controlador}/HojaCurso" 
                                data-total="{$cuenta}"
                                title="Imprimir hojas cursos">
                                <i class=" glyphicon glyphicon-print"></i>
                            </a>
                        {/if}
                        {* {if Session::accesoView('especial')}
                        <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}dinamizador/nuevo">Crear nuevo </a>
                        <a class="btn btn-primary text-capitalize text-default btn-sm" href="{BASE_URL}dinamizador/nuevo_auto">Auto </a>
                        {/if}*}
                    </th>
                    <th></th>
                </tr>
            </thead>
            {foreach item=dato from=$datos}
                <tr>
                    <td class="text-info small">{$dato.row}</td>
                    <td>{$dato.fecha}</td>
                    <td>{$dato.hora}</td>
                    <td>{$dato.curso}</td>
                    <td>{$dato.centro}</td>
                    <td class="text-center">
                        <a title="Ver curso" class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$dato.id}">
                            <span class=" glyphicon glyphicon-eye-open"></span>
                        </a>
                        {if Session::accesoViewEstricto(array('especial'))}
                            <a title="Editar curso" class="btn btn-default btn-round" href="{BASE_URL}{$controlador}/editar/{$dato.id}">
                                <span class=" glyphicon glyphicon-pencil"></span>
                            </a>
                        {/if}
                        {if Session::accesoViewEstricto(array('especial'))}
                            <a 
                                class="btn btn-danger btn-round"
                                href="#" 
                                data-toggle="modal" 
                                data-target="#confirmar-borrar" 
                                data-href="{BASE_URL}{$controlador}/eliminar/{$dato.id}" 
                                data-curso="{$dato.curso}"
                                data-alumno=""
                                title="Borrar curso">
                                <i class=" glyphicon glyphicon-trash"></i>
                            </a>
                            {*                            <a title="Borrar curso" class="btn btn-danger btn-round" href="{BASE_URL}{$controlador}/eliminar/{$dato.id}">*}
                            {*                                <span class=" glyphicon glyphicon-trash"></span>*}
                            {*                            </a>*}
                        {/if}
                    </td>
                    <td>

                        <a title="Matricular alumnos" class="btn btn-suave btn-round" href="{BASE_URL}{$controlador}/matricular/{$dato.id}">
                            <span class=" glyphicon glyphicon-list"></span>
                        </a>
                    </td>
                </tr>
            {/foreach}
        </table>
        <hr>
        {$paginacion}
    {else}
        <div class="alert alert-warning">
            No hay cursos que cumplan con las condiciones
        </div>
    {/if}
</div>


<!--modal confirmar borrar curso-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar matr&iacute;cula del alumno</h4>
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

<!--modal confirmar imprimir hojas cursos-->
<div class="modal fade" id="confirmar-imprimir-hojas-cursos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo-modal"></h4>
            </div>
            <div class="modal-body">
                Va a crear un total de <span id="total" class="text-primary"></span> p&aacute;ginas,¿est&aacute; seguro? 
                <form id="form-imprimir" role="form" class="form-horizontal" action="" method="post" name="imprimir">     
                    <div class="col-md-10 col-md-push-2">
                        <input type="checkbox" id="alumnos" name="alumnos" value="alumnos" checked/> Incluir nombres de alumno
{*                        <label for="alumnos" class="control-label"></label>*}
                    </div>
                </form>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input class="btn btn-success" type="submit" value="Aceptar" form="form-imprimir" id="submit">
            </div>
        </div>
    </div>
</div>
