
<div class="row">
    <form class="alert alert-info col-md-3" action="{BASE_URL}estadisticas/index1" method="post" >

        <div class="form-group ">
            <label class="control-label">Consulta: </label><br/>
            <div>
                <select class='form-control' name="sql" onchange="this.form.submit()">
                    {foreach from=$metodos_sql item=item}
                        {if ($sql == $item.id)}
                            <option value='{$item.id}' selected>{$item.nombre}</option>
                        {else}
                            <option value='{$item.id}' >{$item.nombre}</option>
                        {/if}
                    {/foreach}
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class='row'>
                <div class="col-md-6">
                    <label class="control-label" for="desde">Desde</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                               value="">
                    </div>     
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class='row'>
                <div class="col-md-6">
                    <label  class="control-label" for="hasta">Hasta</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd" 
                               value="" >
                    </div>                                
                </div>                                
            </div>
        </div>

    </form>


    <div class="col-md-8">

        {if isset($datos) && count($datos)}
            <table class="table table-striped table-hover {*table-condensed*}">
                <thead class="bg-primary">
                    <tr>
                        {foreach from=$cols item=col}
                            <th class="text-center">{$col}</th>
                            {/foreach}
                    </tr>
                </thead>
                {foreach item=dato from=$datos}
                    <tr>
                        {foreach from=$dato item=item key=key}
                            {if (isset($formato.$key.accion) && $formato.$key.accion=='round')}
                                <td class="{$formato.$key.estilo|default:''}">{$item|number_format:2} {$formato.$key.simbolo|default:''}</td>
                            {else}
                                <td class="{$formato.$key.estilo|default:''}">{$item} {$formato.$key.simbolo|default:''}</td>
                            {/if}
                        {/foreach}
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
</div>

<div class="row">
    <div class="alert alert-info">
        {$codigo_sql}
    </div>
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