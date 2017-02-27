
                {if isset($_error)}
                    <!--Mensajes privados de cada controlador-->
                    <div class="row">
                        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <h3>Atenci&oacute;n</h3> <hr> 
                            {$_error}
                        </div>
                    </div>
                {/if}

                {if isset($_mensaje)}
                    <!--Mensajes privados de cada controlador-->
                    <div class="row">
                        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <div class="text-center">
                                privado{$_mensaje}
                            </div>
                        </div>
                    </div>
                {/if}
<div class="alert alert-success col-md-6 col-md-push-3">
    <a href="{BASE_URL}" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>
    <br/>
    <form id="form1" name="form1" class="form-horizontal" method="post" action="">
        <input type="hidden" name="enviar" value="1" />
        
            <div class="form-group">
                <label for="signpw" class="control-label col-md-4"><span class="required text-danger"></span>Clave de registro:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-screenshot"></i>
                        <input 
                            class="form-control " 
                            type="password" name="signpw" 
                            value="{$datos.signpw|default:''}" 
                            placeholder="Clave de registro"
                            autofocus/>
                    </div>
                </div>
            </div>
<hr/>

            {*<div class="form-group">
                <label for="nombre" class="control-label col-md-4"><span class="required text-danger"></span>Nombre:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-user"></i>
                        <input 
                            class="form-control " 
                            type="text" name="nombre" 
                            value="{$datos.nombre|default:''}" 
                            placeholder="Nombre y apellidos"
                            />
                    </div>
                </div>
            </div>*}
                            
                            
                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-4">Nombre</label>
                    <div class="col-md-8">
                        <div class="input-group form-inline">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{$datos.nombre|default:''}">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{$datos.apellidos|default:''}">
                        </div>
                    </div>
                </div>
                        

            <div class="form-group">
                <label for="usuario" class="control-label col-md-4"><span class="required text-danger"></span>Usuario:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-chevron-right"></i>
                        <input 
                            class="form-control " 
                            type="text" name="usuario" 
                            value="{$datos.usuario|default:''}" 
                            placeholder="Nombre de usuario"
                            autofocus/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="control-label col-md-4"><span class="required text-danger"></span>Contrase&ntilde;a:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-lock"></i>
                        <input 
                            class="form-control " 
                            type="password" name="password" 
                            value="{$datos.password|default:''}" 
                            placeholder="Contraseña"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password_again" class="control-label col-md-4"><span class="required text-danger"></span>Confirmar:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-lock"></i>
                        <input 
                            class="form-control " 
                            type="password" name="password_again" 
                            value="{$datos.password_again|default:''}" 
                            placeholder="Repita la contraseña"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="control-label col-md-4"><span class="required text-danger"></span>Correo electr&oacute;nico:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-envelope"></i>
                        <input 
                            class="form-control " 
                            type="email" name="email" 
                            value="{$datos.email|default:''}" 
                            placeholder="Dirección de correo electrónico"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="telefono" class="control-label col-md-4"><span class="required text-danger"></span>Tel&eacute;fono:</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <i class="input-group-addon glyphicon glyphicon-phone"></i>
                        <input 
                            class="form-control " 
                            type="text" name="telefono" 
                            value="{$datos.telefono|default:''}" 
                            placeholder="Teléfono"/>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success form-control" value="Crear usuario"/>
    </form>
</div>