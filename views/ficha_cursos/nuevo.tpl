{if Session::accesoViewEstricto(array('admin'))}
    {*<div class="alert alert-warning" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h2>Falta javascript</h2>
        <ul>
            <li>Actualizar profesor al elegir centro</li>
        </ul>
    </div>*}
{/if}

<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>
        {*id
        id_curso COMBO
        id_centro COMBO
        fecha_inicio
        fecha_fin
        hora_inicio
        hora_fin
        horas_totales
        fecha_creacion
        creador
        fecha_modificacion
        modificador   *}

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  

                <div class="form-group ">
                    <label for="id_curso" class="control-label col-md-3">Curso</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_curso" name="id_curso" autofocus>
                                {foreach from=$cursos item=curso}
                                    <option value="{$curso.id}"
                                            {if (isset($datos.id_curso))}
                                                {if ($datos.id_curso == $curso.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}>{$curso.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="id_centro" class="control-label col-md-3">Centro</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-home"></span>
                            <select class="form-control" id="id_centro" name="id_centro">
                                {foreach from=$centros item=centro}
                                    <option value="{$centro.id}"
                                            {if (isset($datos.id_centro))}
                                                {if ($datos.id_centro == $centro.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}
                                            >{$centro.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="id_profesor" class="control-label col-md-3">Profesor</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <select class="form-control" id="id_profesor" name="id_profesor">
                                {foreach from=$profesores item=profesor}
                                    <option value="{$profesor.id}"
                                            {if (isset($datos.id_profesor))}
                                                {if ($datos.id_profesor == $profesor.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}
                                            >{$profesor.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <hr/>

                <div class="form-group col-md-4">
                    <label for="fecha_inicio">Fecha inicio</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="" value="{$datos.fecha_inicio|default:''}" onchange="cambia_fecha()">
                    </div>

                    <label for="fecha_fin" >Fecha fin</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="" value="{$datos.fecha_fin|default:''}">
                    </div>
                </div>

                <div class="col-xs-12 col-md-7 pull-right">
                    <div class="form-group">
                        <label for="hora_inicio" class="col-md-6 text-right" >Hora inicio</label>
                        <div class="input-group col-md-5">
                            <span class="input-group-addon glyphicon glyphicon-time"></span>
                            <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="" value="{$datos.hora_inicio|default:''}" onchange="cambia_hora()">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7 pull-right">
                    <div class="form-group">
                        <label for="hora_fin" class="col-md-6 text-right" >Hora fin</label>
                        <div class="input-group col-md-5">
                            <span class="input-group-addon glyphicon glyphicon-time"></span>
                            <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="" value="{$datos.hora_fin|default:''}">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-7 pull-right">
                    <div class="form-group">
                        <label for="horas_totales" class="col-md-6 text-right" >Horas totales</label>
                        <div class="input-group col-md-5">
                            <span class="input-group-addon glyphicon glyphicon-time"></span>
                            <input type="number" class="form-control" name="horas_totales" id="horas_totales" placeholder="" value="{$datos.hora_totales|default:$horas_curso_defecto}">
                        </div>
                    </div>
                </div>

            </div>
            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>

</div>
