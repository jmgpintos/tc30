{*<div class="col-md-3 well well-lg">

    {include file=$_filtro}
</div>
*}
<div class="col-md-12 pull-right">
     
    
    {if isset($datos) && count($datos)}
        <table class="table table-striped table-hover {*table-condensed*}">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Nivel</th>
                    <th>Usuario</th>
                    <th>Hora</th>
                    <th>M&eacute;todo</th>
                    <th>Mensaje</th>
                    <th>Tabla</th>
                    <th></th>
                </tr>
            </thead>
            {foreach item=dato from=$datos}
                <tr>
                    <td class="text-info small">{$dato.row}</td>
                    <td>{$dato.nivel}</td>
                    <td>{$dato.usuario}</td>
                    <td>{$dato.tiempo}</td>
                    <td>{$dato.metodo}</td>
                    <td>{$dato.mensaje}</td>
                    <td>{$dato.tabla}</td>
                    <td class="text-center">
                        <a title="Ver curso" class="btn btn-primary btn-round" href="{BASE_URL}{$controlador}/ver/{$dato.id}">
                            <span class=" glyphicon glyphicon-eye-open"></span>
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


