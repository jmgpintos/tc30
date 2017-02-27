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

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  

                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-tag"></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="{$datos.nombre|default:''}" autofocus/>

                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="id_tipo" class="control-label col-md-3">Tipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_tipo" name="id_tipo" autofocus>
                                {foreach from=$tipos item=tipo}
                                    <option value="{$tipo.id}"
                                            {if (isset($datos.id_tipo))}
                                                {if ($datos.id_tipo == $tipo.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}>{$tipo.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="id_responsable" class="control-label col-md-3">Tipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_responsable" name="id_responsable" autofocus>
                                {foreach from=$responsables item=responsable}
                                    <option value="{$responsable.id}"
                                            {if (isset($datos.id_responsable))}
                                                {if ($datos.id_responsable == $responsable.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}>{$responsable.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="descripcion" class=" col-md-12">Descripci&oacute;n</label>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-list-alt"></span>
                            <textarea class="form-control" id="descripcion" name="descripcion"
                                      rows="5">{$datos.descripcion|default:''}
                            </textarea>
                        </div>
                    </div>
                </div>
                <hr/>

                <div class="form-group col-md-4 col-md-push-2">
                    <label for="fecha_inicio">Fecha inicio</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="" value="{$datos.fecha_inicio|default:''}">
                    </div>

                    <label for="fecha_fin" >Fecha fin</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="" value="{$datos.fecha_fin|default:''}">
                    </div>
                </div>

                <div class="form-group  col-md-4 pull-right">
                    <label for="hora_inicio">Hora inicio</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-time"></span>
                        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="" value="{$datos.hora_inicio|default:''}">
                    </div>

                    <label for="hora_fin">Hora fin</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-time"></span>
                        <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="" value="{$datos.hora_fin|default:''}">
                    </div>
                </div>

            </div>
            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>

</div>

                    