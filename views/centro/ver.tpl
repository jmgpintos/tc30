
<div class="row">
    <div class="well well-sm col-xs-12 col-md-8 col-md-push-2" >
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>
        <h2 class="text-primary">{$datos.nombre|default:''}</h2><hr>
        <div class="col-xs-12 center-block col-md-7 img-responsive">
            {*            <label for="coordenadas" class="text-right">Localización</label><br>*}
            {if ($datos.mapa|count_characters>0)}
                <iframe class="center-block" style="margin-bottom: 15px;" src="{$datos.mapa|default:''}" frameborder="0" style="border:0" allowfullscreen></iframe>
            {else}
                <img class="mapa" src="{$_layoutParams.ruta_img}mapa.png"/>
            {/if}
        </div>
        <div class="row center-block col-xs-12 col-md-5">
            <div class="alert alert-info text-primary">
                <div >
                    <label for="direccion" class="text-right">Direcci&oacute;n</label><br>
                    {$datos.direccion|default:''}
                </div>

                <div >
                    <label for="telefono" class="text-right">Tel&eacute;fono</label><br>
                    {$datos.telefono|default:''}
                </div>

                <div >
                    <label for="aforo" class="text-right">Aforo</label><br>
                    {$datos.aforo|default:''}
                </div>  

                <div >
                    <label for="fundacion" class="text-right">A&ntilde;o de fundaci&oacute;n</label><br>
                    {$datos.fundacion|default:''}
                </div>  
            </div>
        </div>
        <div class="row col-xs-8 col-xs-push-2 col-md-6 col-md-push-3">

            <a href="javascript:history.back(1)" class=" center-block btn btn-primary col-md-12">Volver al listado</a>
        </div>
    </div>
</div>
                <hr/>
<div class="col-md-6 col-md-push-3">
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th colspan="2">Lista de Equipos</th>
                <th class="text-center">
{*                    {if Session::accesoView('especial')}*}
                        <a class="btn btn-primary btn-round" title="Nuevo Equipo" href="{BASE_URL}equipo/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
{*                        {/if}*}
                </th>
            </tr>
        </thead>
        {foreach item=item from=$equipos}
            <tr>
                <td class="text-info small">{$item.row}</td>
                <td>{$item.nombre}</td>
                <td class="text-center">
                    {if Session::accesoView('especial')}
                        <a class="btn btn-default btn-round" title="Editar" href="{BASE_URL}equipo/editar/{$item.id}"><i class="glyphicon glyphicon-pencil"></i></a>
                        {/if}
                        <a class="btn btn-primary btn-round" title="Editar" href="{BASE_URL}equipo/ver/{$item.id}"><i class="glyphicon glyphicon-eye-open"></i></a>
                </td>
            </tr>
        {/foreach}
    </table>              
</div>

