<div class="well well-sm col-xs-12 col-md-3">
    <div class="alert bg-info info-alumno col-md-12">
        <div class=" col-md-12">
            <a href="{$ref}" class="btn btn-sm btn-success" title="Volver">
                <i class="glyphicon glyphicon-chevron-left"></i>
            </a>
            {*<a href="{BASE_URL}alumno/volver" class="btn btn-sm btn-success" title="Volver">
                <i class="glyphicon glyphicon-chevron-left"></i>
            </a>*}
            {*<a href="{BASE_URL}ficha_cursos/index/{Session::get('pagina')}" class="col-md-8 pull-right text-right btn btn-primary">Volver al listado</a>*}
            <div class="pull-right">
                <a href="{BASE_URL}alumno/editar/{$datos.id}" class="btn btn-default btn-round" title="Editar">
                    <span class=" glyphicon glyphicon-pencil"></span>
                </a>
                {if Session::accesoView('especial')}
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="{BASE_URL}alumno/eliminar/{$datos.id}" 
                            data-alumno="{$datos.nombre}"
                            title="Borrar alumno">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                {/if}
            </div>
        </div>
            
        <h3 class="col-md-2">
            {if $datos.sexo=='H'}
                <i class="fa fa-2x fa-male" title="Hombre"></i>
            {else}
                <i class="fa fa-2x fa-female" title="Mujer"></i>
            {/if}
        </h3>
        <h3 class="col-md-7">{$datos.nombre|default:''}</h3>

        <div class="col-md-12 text-right ">
            <strong>{$datos.dni|default:''}</strong>
        </div>
    </div>
    {*<label>NIF/NIE</label><br/>
    <div class="col-md-11 col-md-push-1">
    <div class="text-right" >{$datos.dni|default:''}</div>
    </div>*}
    <div class="panel-group text-center" >

        {if $datos.discapacidad==TRUE}
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <label >Persona con discapacidad</label>
                </div>
            </div>
        {/if}            

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Alumno desde</label>
            </div>
            <div class="panel-body text-info">
                {$datos.fecha_alta|default:''}
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Teléfono</label>
            </div>
            <div class="panel-body text-info">
                {$datos.telefono|default:''}
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Fecha de Nacimiento</label>
            </div>
            <div class="panel-body text-info">
                {$datos.fechaNac|default:''}
            </div>
        </div>

    </div><!--panel-group-->

</div>
{*        </form>*}
{*        </div>*}

<div class="col-xs-12 col-md-7 col-md-push-1">
    {*    <h2>Cursos</h2>*}

    {if isset($cursos) && count($cursos)}
    <div class="alert alert-info"><h2 class="text-center">Cursos</h2></div>
        <table class="table table-striped table-hover table-condensed">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th class="hidden-xs">Hora</th>
                    <th>Curso</th>
                    <th class="hidden-xs">Telecentro</th>
                    <th class="hidden-xs">Certificado</th>
                    <th class="text-center">
                    </th>
                </tr>
            </thead>
            {foreach item=item from=$cursos}
                <tr>
                    <td class="text-info small">{$item.row}</td>
                    <td>{$item.fecha_inicio}</td>
                    <td class="hidden-xs">{$item.hora_inicio}</td>
                    <td {if $item.nombre_curso!=$item.nombre_curso_elipsis }title="{$item.nombre_curso}"{/if}>
                        {($item.nombre_curso_elipsis)}
                    </td>
                    <td  class="hidden-xs" {if $item.nombre_centro!=$item.nombre_centro_elipsis}title="{$item.nombre_centro}{/if}">
                        {($item.nombre_centro_elipsis)}
                    </td>
                    <td class="hidden-xs text-center">
                        <a 
                            class="btn btn-default btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#modal-certificado" 
                            data-href="{BASE_URL}ficha_cursos/certificado/{$item.id_ficha_curso}/{$datos.id}" 
                            data-curso="{$item.nombre_curso}"
                            data-alumno="{$datos.nombre}"
                            title="Obtener certificado">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        {* {if $item.certificado==1}
                        <span class="glyphicon glyphicon-ok text-success"></span>
                        {else}
                        <span class="glyphicon glyphicon-remove text-danger"></span>
                        {/if}*}
                    </td>
                    <td class="text-center">
                        <a href="index.phtml"></a>
                        {*{if Session::accesoViewEstricto(array('especial'))}*}
                        <a class="btn btn-primary btn-round" href="{BASE_URL}ficha_cursos/ver/{$item.id_ficha_curso}" title="Ver ficha del curso"><span class=" glyphicon glyphicon-eye-open"></span></a>
                            {*{/if}                        {if Session::accesoViewEstricto(array('especial'))}
                            <a class="btn btn-default btn-round" href="{BASE_URL}alumno/editar/{$item.id}" title="Editar datos del curso"><span class=" glyphicon glyphicon-pencil"></span></a>
                            {/if}
                            {if Session::accesoViewEstricto(array('especial'))}
                            <a class="btn btn-danger btn-round" href="{BASE_URL}alumno/eliminar/{$item.id}" title="Borrar curso"><span class=" glyphicon glyphicon-trash"></span></a>
                            {/if}*}
                    </td>
                </tr>
            {/foreach}
        </table>
        {if ($paginas==1)}
            {$paginacion}
        {/if}
    {else}
        <div class="alert alert-warning">
            No hay cursos
        </div>
    {/if}
</div>
</div>

<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo-modal"></h4>
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

        
<!--modal certificado-->
<div class="modal fade" id="modal-certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Obtener certificado</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-push-2">
                    Obtener certificado de <span id="cert-nombre-alumno" class="text-primary"></span> <br/>
                    para el curso <span id="cert-curso" class="text-primary"></span>
                </div>
                <div class="row"></div>
                <hr/>

                <form id="form-fecha" role="form" class="form-horizontal" action="" method="post" name="fecha">     
                    <div class="row col-md-12">
                        <div class="form-group ">
                            <label for="fecha_certificado" class="control-label col-md-4">Fecha</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                                    <input class="form-control" type="date" id="fecha_certificado" name="fecha_certificado" value="{$hoy}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="margen" class="control-label col-md-4">Margen</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-resize-horizontal"></span>
                                    <input class="form-control" type="number" id="margen" name="margen" value="25">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input class="btn btn-success" type="submit" value="Aceptar" form="form-fecha" id="submit">
                {*                                <a class="btn btn-danger btn-ok">Aceptar</a>*}
            </div>
        </div>
    </div>
</div>

