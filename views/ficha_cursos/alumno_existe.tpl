<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-div="close">&times;</a>

        <div class="row col-md-12">  

            <div class="display-label col-md-4">DNI</div>
            <div class="display-values col-md-8">
                {$datos.dni|default:''}
            </div>

            <div class="row"></div>
            <div class="display-label col-md-4">Nombre y apellidos</div>
            <div class="display-values col-md-8">
                {if $datos.sexo=='H'}
                    <i class="fa fa-male" title="Hombre"></i>
                {else}
                    <i class="fa fa-female" title="Mujer"></i>
                {/if}
                {$datos.nombre}
            </div>

            <div class="row"></div>
            <div class="display-label col-md-4">Fecha de Nacimiento</div>
            <div class="display-values col-md-8">
                {$datos.fechaNac|default:''}
            </div>

            <div class="row"></div>
            <div class="display-label col-md-4">Teléfono</div>
            <div class="display-values col-md-8">
                {$datos.telefono|default:''}
            </div>

            <div class="row"></div>
            <div class="display-label col-md-4">Fecha de Alta</div>
            <div class="display-values col-md-8">
                {$datos.fecha_alta|default:''}
            </div>

            <div class="row"></div>
            <div class="col-md-push-4 col-md-8 text-danger">
                {if isset($datos.discapacidad) && $datos.discapacidad==1}
                    Discapacitado
                {/if}
            </div>
        </div>
        <div class="row"></div>

        <hr/>

        <form role="form" class="form-horizontal" action="{BASE_URL}ficha_cursos/matricularAlumno/{$id_ficha_curso}/{$datos.id}" method="post">     
            <input type="hidden" name="matricular" value="1" />
            <div class="row col-md-12">  

                <div class="form-group  col-md-6">
                    <label for="id_curso" class="control-label">Ocupacion</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-briefcase"></span>
                        <select class="form-control" id="id_curso" name="id_ocupacion">
                            {foreach from=$ocupaciones item=item}
                                {if isset($datos_matricula.id_ocupacion) && ($datos_matricula.id_ocupacion == $item.id)}
                                    <option value="{$item.id}" selected>{$item.nombre}</option>
                                {else}
                                    {if ($item.id==0)}
                                    <option value="{$item.id}" selected>{$item.nombre}</option>
                                    {else}
                                    <option value="{$item.id}">{$item.nombre}</option>
                                    {/if}
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-6 pull-right">
                    <label for="id_curso" class="control-label">Municipio</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-globe"></span>
                        <select class="form-control" id="id_curso" name="id_municipio">
                            {foreach from=$municipios item=item}
                                {if isset($datos_matricula.id_municipio) && ($datos_matricula.id_municipio == $item.id)}<option value="{$item.id}" selected>
                                        {$item.nombre}</option>
                                    {else}
                                    {if ($item.id==0)}
                                    <option value="{$item.id}" selected>{$item.nombre}</option>
                                    {else}
                                    <option value="{$item.id}">{$item.nombre}</option>
                                    {/if}
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="row"></div>

                <div class="form-group col-md-6">
                    <label for="id_curso" class="control-label">Nivel estudios</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-education"></span>
                        <select class="form-control" id="id_curso" name="id_estudios">
                            {foreach from=$estudios item=item}
                                {if isset($datos_matricula.id_nivel_estudios) && ($datos_matricula.id_nivel_estudios == $item.id)}
                                    <option value="{$item.id}" selected>{$item.nombre}</option>
                                {else}
                                    {if ($item.id==0)}
                                    <option value="{$item.id}" selected>{$item.nombre}</option>
                                    {else}
                                    <option value="{$item.id}">{$item.nombre}</option>
                                    {/if}
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-group  col-md-3 col-md-push-1">
                    <label for="id_curso" class="control-label">Paro</label><br/>
                    <input type="number" class="form-control" title="Meses en paro" id="paro" name="paro" placeholder="meses" value="{$datos_matricula.antiguedad_paro|default:''}">
                </div>

                <div class="form-group  col-md-3 pull-right">
                    <label for="id_curso" class="control-label">CP</label><br/>
                    <input type="text" class="form-control" title="Código Postal" id="cp" name="cp" placeholder="Código Postal" value="{$datos_matricula.codigo_postal|default:''}">
                </div>
                <div class="row"></div>

            </div>
            <a href="javascript:history.back(1)" class="col-md-3 btn btn-warning" data-dismiss="alert" aria-div="close">Cancelar</a>
            <input type="submit" class="col-md-8 col-md-push-1 btn btn-success" value={if $accion=='nuevo'}"Matricular"{else}"Guardar datos"{/if}/>
        </form>

    </div>
</div>