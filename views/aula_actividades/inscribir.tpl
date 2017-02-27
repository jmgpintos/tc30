<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="javascript:history.back();" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">NIF/NIE</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Introduzca DNI/NIE" value="{$dni|default:''}" autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
            <a href="javascript:history.back();" 
               class="hidden-md hidden-lg col-xs-5 btn btn-warning" title="Volver sin guardar">
                Volver</a>
            <input type="submit" class="hidden-md hidden-lg col-xs-5 pull-right  btn btn-success" value="Continuar"/>
            <input type="submit" class="visible-lg btn btn-success form-control" value="Continuar"/>

    </div>
</form>
</div>
<div class="col-md-6 col-md-push-3">
    <hr/>
    <h2>
        Usuarios inscritos
{*        <span class="small text-right">{$plazas_libres} Plaza{if ($plazas_libres>1)}s{/if} libre{if ($plazas_libres>1)}s{/if}</span>*}
    </h2>
    {if isset($usuarios) && count($usuarios)}
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
                </tr>
            </thead>
            {*'discapacidad' => string '0' (length=1)
            'sexo' => string 'H' (length=1)*}
            {foreach item=item from=$usuarios}
                <tr>
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
                    <td>
                        <a class="btn btn-primary btn-round" href="{BASE_URL}aula_usuarios/ver/{$item.id}" title="Ver ficha del alumno">
                            <i class=" glyphicon glyphicon-eye-open"></i>
                        </a>
                    </td>
                </tr>
            {/foreach}
        </table>
    {else}
        <div class="alert alert-warning">
            No hay alumnos matriculados
        </div>
    {/if}
</div>