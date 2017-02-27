<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="{BASE_URL}incidencias/index/{Session::get('pagina')}" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <div class="row col-md-12">  

            <form role="form" class="form-horizontal" action="" method="post"> 
                <input type="hidden" name="guardar" value="1" />  
                <br/>
                
                
                <div class="form-group ">
                    <label for="id_centro" class="control-label col-md-3">Centro</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-home"></span>
                            <select class="form-control" id="id_centro" name="id_centro" disabled>
                                {foreach from=$centros item=item}
                                    <option value="{$item.id}"
                                            {if (isset($centro))}
                                                {if ($centro == $item.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}
                                            >{$item.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                                
                
                <div class="form-group ">
                    <label for="id_centro" class="control-label col-md-3">Equipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-console"></span>
                            <select class="form-control" id="id_equipo" name="id_equipo">
                                {foreach from=$equipos item=equipo}
                                    <option value="{$equipo.id}"
                                            {if (isset($datos.id_equipo))}
                                                {if ($datos.id_equipo == $equipo.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}
                                            >{$equipo.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                                
                <div class="form-group ">
                    <label for="id_centro" class="control-label col-md-3">Tipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-chevron-right"></span>
                            <select class="form-control" id="id_tipo" name="id_tipo">
                                {foreach from=$tipos item=tipo}
                                    <option value="{$tipo.id}"
                                            {if (isset($datos.id_tipo))}
                                                {if ($datos.id_tipo == $tipo.id)}
                                                    selected="selected"
                                                {/if}
                                            {/if}
                                            >{$tipo.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
   
                <hr/>

                <div class="form-group ">
                    <label for="solucion" class="control-label col-md-3">Descripci&oacute;n</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-ok"></span>
                            <textarea rows="5" class="form-control" name="descripcion" id="descripcion" 
                                      placeholder="descripci&oacute;n" >{$datos.descripcion|default:''}</textarea>
                        </div>
                    </div>
                </div>        
{*
                <div class="form-group ">
                    <label for="solucion" class="control-label col-md-3">Soluci&oacute;n</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-ok"></span>
                            <textarea rows="5" class="form-control" name="solucion" id="solucion" 
                                      placeholder="Introduzca la soluci&oacute;n y la fecha de cierre" >{$datos.solucion|default:''}</textarea>
                        </div>
                    </div>
                </div>        

                <div class="form-group ">
                    <label for="fecha_cierre" class="control-label col-md-3">Fecha de Cierre</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_cierre" id="fecha_cierre" placeholder="Fecha de nacimiento" value="{$datos.fecha_cierre|default:''}">
                        </div>
                    </div>
                </div>
*}
                <a href="{BASE_URL}incidencias/index/{Session::get('pagina')}" 
                   class="hidden-md hidden-lg col-xs-5 btn btn-warning" title="Volver sin guardar">
                    Volver</a>
                <input type="submit" class="hidden-md hidden-lg col-xs-5 pull-right  btn btn-success" value="Guardar"/>
                <input type="submit" class="visible-lg btn btn-success form-control" value="Guardar"/>

            </form>
        </div>
    </div>
</div>