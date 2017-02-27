<div class="row">
    <div class="well well-sm col-md-4 ">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

            <h2 class="text-primary">
                {$datos.nombre|default:''}
                {if $datos.especial==1}
                    <small class="text-danger" style='font-variant: small-caps' title="No se tendrá en cuenta para estadísticas">Especial</small>
                {/if}
            </h2>
            <hr>

            <div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading text-center"><label>Categor&iacutea</label></div>
                    <div class="panel-body text-info text-center">
                        {$datos.categoria|default:''}
                    </div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading text-center"><label>Requisitos</label></div>
                    <div class="panel-body text-info text-center" >
                        {$datos.requisitos|default:''}
                    </div>
                </div>

                {if ($datos.descripcion|count_characters>0)}
                    <div class="panel panel-success">
                        <div class="panel-heading text-center"><label>Descripci&oacute;n</label></div>
                        <div class="panel-body text-info text-center" >
                            {$datos.descripcion|default:''}
                        </div>
                    </div>
                {/if}
            </div>
        <a href="{BASE_URL}curso/index/{$pagina}" class="btn btn-primary col-md-12">Volver al listado</a>
    </div>

    {if isset($cursos) && count($cursos)}
        <div class="col-md-7">
            <table class="table table-striped table-hover table-condensed">
                <thead class="bg-primary">
                    <tr>
                        <th></th>
                        <th>Hora</th>
                        <th>Fecha</th>
                        <th>Centro</th>
                        <th>Profesor</th>
                        <th></th>
                    </tr>
                </thead>
                {foreach from=$cursos item=curso}
                    <tr>
                        <td class="text-info small">{$curso.row}</td>
                        <td>{$curso.hora}</td>
                        <td>{$curso.fecha}</td>
                        <td>{$curso.centro}</td>
                        <td>{$curso.profesor}</td>
                        <td><a class ="btn btn-round btn-primary" href="{BASE_URL}ficha_cursos/ver/{$curso.id_ficha_curso}"><i class="glyphicon glyphicon-eye-open"></i></a></td>
                    </tr>
                {/foreach}
            </table>
            {$paginacion}
        </div>
{else}
        <div class="alert alert-warning col-md-push-1 col-md-6">
            No se han programado cursos de <span class="text-primary text-uppercase">{$datos.nombre|default:''}</span>
        </div>    
    {/if}

</div>