<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  
                <div class="form-group ">
                    <label for="usuario" class="control-label col-md-3">Usuario</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-chevron-right"></span>
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Nombre de usuario" value="{$datos.usuario|default:''}" autofocus/>
                        </div>
                    </div>
                </div>
                        
                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre y apellidos</label>
                    <div class="col-md-9">
                        <div class="input-group form-inline">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{$datos.nombre|default:''}">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{$datos.apellidos|default:''}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="password" class="control-label col-md-3">Contrase&ntilde;a</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-lock"></span>
                            <input type="password" class="form-control" name="password" id="nombre" placeholder="Contrase&ntilde;a" value="{$datos.password|default:''}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label for="password_again" class="control-label col-md-3">Confirmar Contrase&ntilde;a </label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-ok-sign"></span>
                            <input type="password" class="form-control" name="password_again" id="nombre" placeholder="Repita la Contrase&ntilde;a" value="{$datos.password_again|default:''}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="control-label col-md-3">Correo electrónico</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-envelope"></span>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" value="{$datos.email|default:''}">
                        </div>
                    </div>
                </div>
                        
                <div class="form-group ">
                    <label for="telefono" class="control-label col-md-3">Teléfono</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-phone"></span>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
                        </div>
                    </div>
                </div>
                        
                <div class="form-group ">
                    <label for="centro" class="control-label col-md-3">Centro</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-home"></span>
                            <select  id="id_centro" name="id_centro" class="form-control">
                                {foreach from=$centros item=centro}
                                    <option value='{$centro.id}' 
                                            {if (!isset($datos.id_centro) && $centro.id==0)} disabled selected
                                            {/if}
                                            {if (isset($datos.id_centro) && $datos.id_centro==$centro.id)}
                                                selected
                                            {/if}
                                            >{$centro.nombre}</option>
                                {/foreach}
                                
                            </select>
{*                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">*}
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>
</div>
