<div class="col-md-12">
        <h2 class="text-primary">Filtrar listado</h2>
</div>
<hr/>

<form class="col-md-12" role="form" method="post" action="{BASE_URL}{$controlador}/index/{$pagina}">
    <div class="form-group ">
        <label for="nombre" class="control-label">Curso</label>
        <div>
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                <select class="form-control" id="id_curso" name="id_curso" autofocus
                        onchange="this.form.submit()">
                    {foreach from=$cursos item=curso}
                        <option value="{$curso.id}"
                                {if (isset($filtro.id_curso) && $curso.id==$filtro.id_curso)}
                                    selected="selected"
                                {/if}                                        
                                >
                            {$curso.nombre}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>

    <div class="form-group ">
        <label for="nombre" class="control-label">Centro</label>
        <div>
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-home"></span>
                <select class="form-control" id="id_centro" name="id_centro"
                        onchange="this.form.submit()">
                    {foreach from=$centros item=centro}
                        <option value="{$centro.id}"
                                {if (isset($filtro.id_centro) && $centro.id==$filtro.id_centro)}
                                    selected="selected"
                                {/if}>
                            {$centro.nombre}
                        </option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>

    <div class="form-group ">
        <label for="desde">Desde</label><br/>
        <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
            <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                   value="{$filtro.desde|default:''}" onchange="this.form.submit()">
        </div>
    </div>

    <div class="form-group ">
        <label for="hasta">Hasta</label><br/>
        <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
            <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd"
                   value="{$filtro.hasta|default:''}" onchange="this.form.submit()">
        </div>
    </div>
    <button class="form-control btn
            {if ($filtrado)}}
                btn-danger
            {else}
                btn-primary disabled hidden
            {/if}
            " name="limpiar" value="limpiar">Limpiar filtro</button>
</form>
