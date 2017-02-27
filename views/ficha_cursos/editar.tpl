<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">

        {if Session::accesoViewEstricto(array('admin'))}
            <div class="alert alert-warning fade in" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Falta javascript</h2>
                <ul>
                    <li>Actualizar campos "fin" al cambiar valor de "inicio" (si "fin" está vacío)</li>
                    <li>Usar polyfill para campos fecha</li>
                </ul>
            </div>
        {/if}
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

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

                <div class="form-group col-md-12">
                    <div class="form-group col-md-5 col-md-push-1">
                        <label for="fecha_inicio">Fecha inicio</label><br/>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="" value="{$datos.fecha_inicio|default:''}">
                        </div>
                    </div>

                    <div class="form-group col-md-6 pull-right">
                        <label for="fecha_fin" >Fecha fin</label><br/>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="" value="{$datos.fecha_fin|default:''}">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-md-push-1">
                    <div class="form-group col-md-3">
                        <div class="form-group">
                            <label for="hora_inicio">Hora inicio</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="" value="{$datos.hora_inicio|default:''}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-3 col-md-push-2">
                        <div class="form-group text-center">
                            <label for="hora_fin">Hora fin</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="" value="{$datos.hora_fin|default:''}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-3 pull-right">
                        <div class="form-group text-right">
                            <label for="horas_totales" >Horas totales</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="number" class="form-control" name="horas_totales" id="horas_totales" placeholder="" value="{$datos.horas_totales|default:''}">
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            <div class="row"></div>
            <a href="{BASE_URL}alumno/index/{Session::get('pagina')}" 
               class="visible-xs col-xs-12 btn btn-warning" title="Volver sin guardar">
                Volver</a>
               <hr/>
            <input type="submit" class="visible-xs col-xs-12 pull-right  btn btn-success" value="Guardar"/>
            <input type="submit" class="hidden-xs btn btn-success form-control" value="Guardar"/>

{*                <input type="submit" class="btn btn-success form-control" value="Guardar"/>*}
            </div>
        </form>

    </div>


    {*{vardump($datos)}
    {vardump($cursos)}
    {vardump($centros)}
    {vardump($profesores)}*}