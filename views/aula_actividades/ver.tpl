<div class="row">
    <div class="well well-sm col-xs-12 col-md-4">
        <div class="alert bg-info col-md-12 info-curso">
            <div class="pull-right ">
                <a href="{BASE_URL}{$controlador}/editar/{$datos.id}" class="btn btn-default btn-round" title="Editar">
                    <span class=" glyphicon glyphicon-pencil"></span>
                </a>
                {if Session::accesoView('especial')}
                    <a class="btn btn-danger btn-round" href="{BASE_URL}ficha_cursos/eliminar/{$datos.id}" title="Borrar alumno">
                        <span class=" glyphicon glyphicon-trash"></span>
                    </a>
                {/if}
            </div>

            <h3 class="col-md-12">{$datos.nombre|default:''}</h3>

            <div class="col-md-12 text-right ">
                <small>Responsable: {$datos.responsable|default:''}</small>
            </div>
        </div>


        <div class="panel-group">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"><label>Fechas</label></div>
                    <div class="panel-body text-info text-center">
                        {$datos.fechas_largo|default:''}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"><label>Horario</label></div>
                    <div class="panel-body text-info text-center" >{$datos.horas|default:''} </div>
                </div>
            </div>
        </div>
        <div class="alert col-md-12">
            {$datos.descripcion|default:''}
        </div>

        <div class=" col-md-12">
            {*        <a href="{$ref}" class="col-md-8 pull-right text-right btn btn-primary">*}
            <a href="{BASE_URL}{$controlador}/index/{$pagina_listado}" class="col-md-8 pull-right text-right btn btn-primary">
                <i class="glyphicon glyphicon-chevron-left"></i>
                Volver al listado</a>
                {* <a href="{BASE_URL}ficha_cursos/volver" class="col-md-8 pull-right text-right btn btn-primary">
                <i class="glyphicon glyphicon-chevron-left"></i>
                Volver al listado</a>*}
        </div>
    </div>


    <div class="col-xs-12 col-md-8 ">

        {if isset($_error)}
            <!--Mensajes privados de cada controlador-->
            <div class="row">
                <div class="alert alert-danger fade in">
                    <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                    <h3>Atenci&oacute;n</h3> <hr> 
                    {$_error}
                </div>
            </div>
        {/if}

        {if isset($_mensaje)}
            <!--Mensajes privados de cada controlador-->
            <div class="row">
                <div class="alert alert-success fade in">
                    <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                    <div class="text-center">
                        {$_mensaje}
                    </div>
                </div>
            </div>
        {/if}

        {if isset($usuarios) && count($usuarios)}
    <div class="alert alert-info"><h2 class="text-center">Usuarios</h2></div>
            <table class="table table-striped table-hover table-condensed">
                <thead class="bg-primary">
                    <tr>
                        <th></th>
                        <th>DNI</th>
                        <th class="hidden-xs">Nombre</th>
                        <th>Telefono</th>
                            {*<th class="hidden-xs">Telecentro</th>
                            <th class="hidden-xs">Certificado</th>*}
                        <th></th>
                        <th class="text-center">
                            {* {if ($datos.aforo > $matriculados)}*}
                            <a class="btn btn-primary btn-round" title="Inscribir usuario" href="{BASE_URL}{$controlador}/inscribir/{$datos.id}"><i class="glyphicon glyphicon-plus"></i></a>{*{$plazas_libres}*}
                                {*{else}
                                <span class="label label-warning label-as-badge">No hay plazas libres</span>
                                {/if}*}
                        </th>
                    </tr>
                </thead>
                {*'discapacidad' => string '0' (length=1)
                'sexo' => string 'H' (length=1)*}
                {foreach item=item from=$usuarios}
                    <tr >
                        <td class="text-info small">
                            {$item.row}
                        </td>
                        <td>{$item.dni}</td>
                        <td class="hidden-xs">
                            {if ($item.sexo=='H')}
                                <i class='fa fa-male fa-fw' title="Hombre"></i>
                            {else}
                                <i class='fa fa-female fa-fw' title="Mujer"></i>
                            {/if}
                            {$item.nombre}
                        </td>
                        <td>{($item.telefono)}</td>
                        <td class="text-center">
                            {* <a 
                            class="btn btn-default btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#modal-certificado" 
                            data-href="{BASE_URL}ficha_cursos/certificado/{$datos.id}/{$item.id}" 
                            data-curso="{$datos.curso}"
                            data-alumno="{$item.nombre}"
                            title="Obtener certificado">
                            <i class="fa fa-file-pdf-o"></i>
                            </a>*}
                        </td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-round" href="{BASE_URL}aula_usuarios/ver/{$item.id}" title="Ver ficha del alumno">
                                <i class=" glyphicon glyphicon-eye-open"></i>
                            </a>
                            {*{/if} *}                        

                            <a class="btn btn-default btn-round" href="{BASE_URL}aula_actividades/editarInscripcion/{$datos.id}/{$item.id}" title="Editar datos de inscripci&oacute;n">
                                <i class=" glyphicon glyphicon-pencil"></i>
                            </a>

                            <a 
                                class="btn btn-danger btn-round"
                                href="#" 
                                data-toggle="modal" 
                                data-target="#confirmar-borrar" 
                                data-href="{BASE_URL}aula_actividades/borrarInscripcion/{$datos.id}/{$item.id}" 
                                data-curso="{$datos.nombre}"
                                data-alumno="{$item.nombre}"
                                title="Borrar {$titulo}">
                                <i class=" glyphicon glyphicon-remove-circle"></i>
                            </a>
                        </td>
                    </tr>
                {/foreach}
            </table>
            {if ($paginas==1)}
                {$paginacion}
            {/if}
        {else}
            <div class="alert alert-warning">
                No hay usuarios<hr/>
                <a class="btn btn-primary" title="Inscribir usuario" href="{BASE_URL}{$controlador}/inscribir/{$datos.id}"><i class="glyphicon glyphicon-plus"></i>Inscribir</a>
            </div>
        {/if}

    </div>
</div>

<!--modal confirmar borrado matrícula-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar inscripci&oacute;n</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-push-2">
                    ¿Desea borrar la inscripci&oacute;n de <span id="nombre-alumno" class="text-primary"></span> 
                    de la actividad <span id="curso" class="text-primary"></span>?
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
                                    <input class="form-control" type="date" id="fecha-certificado" name="fecha_certificado"  placeholder="aaaa-mm-dd" value="">
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
            </div>
        </div>
    </div>
</div>
