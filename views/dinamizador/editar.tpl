<div class="row col-md-6 col-md-push-3">

    <ul class="nav nav-tabs"id="myTab">
        <li class="active"><a data-toggle="tab" href="#menu1">Perfil</a></li>
        <li><a data-toggle="tab" href="#menu2">Cambiar contrase&ntilde;a</a></li>
        <li><a data-toggle="tab" href="#menu3">Preferencias</a></li>
    </ul>

    <div class="tab-content">
        <div id="menu1" class="tab-pane fade in active">
{*            <h3>Datos del usuario</h3>*}
{*            <hr/>*}
<br>
            <form  role="form" class="form-horizontal" action="" method="post">     
                <input type="hidden" name="guardar_perfil" value="1" />

                <div class="row col-md-12">  
                    <div class="form-group ">
                        <label for="usuario" class="control-label col-md-4">Usuario</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-chevron-right"></span>
                                <input type="text" class="form-control" name="usuario" id="menu1focus" placeholder="Nombre de usuario" value="{$datos.usuario|default:''}" autofocus/>
                            </div>
                        </div>
                    </div>
                    
                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-4">Nombre y apellidos</label>
                    <div class="col-md-8">
                        <div class="input-group form-inline">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{$datos.nombre|default:''}">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{$datos.apellidos|default:''}">
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-4">e-mail</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-envelope"></span>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" value="{$datos.email|default:''}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="telefono" class="control-label col-md-4">Teléfono</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-phone"></span>
                                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
                            </div>
                        </div>
                    </div>


                    {if Session::accesoView('especial')}
                        <div class="form-group ">
                            <label for="telefono" class="control-label col-md-4">Centro</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-phone"></span>
                                    <select  id="id_centro" name="id_centro" class="form-control">
                                        {foreach from=$centros item=centro}
                                            <option value='{$centro.id}' 
                                                    {if ($datos.id_centro==$centro.id)}
                                                        selected
                                                    {/if}
                                                    >{$centro.nombre}</option>
                                        {/foreach}
                                    </select>
                                </div>
                            </div>
                        </div>
                    {/if}

                    {if isset($_errorNum) && ($_errorNum==1)}
                        {if isset($_error)}
                            <!--Mensajes privados de cada controlador-->
                            <div class="row">
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error: </strong>{$_error}
                                </div>
                            </div>
                        {/if}
                    {/if}

                </div>
                <input type="submit" class="btn btn-success form-control" value="Guardar"/>
            </form>
        </div>
        <div id="menu2" class="tab-pane fade">
{*            <h3>Contrase&ntilde;a</h3>*}
{*            <hr/>*}
<br>
            <form  role="form" class="form-horizontal" action="" method="post">     
                <input type="hidden" name="guardar_pw" value="1" />

                <div class="row col-md-12">  
                    <div class="form-group ">
                        <label for="pw_actual" class="control-label col-md-4">Contrase&ntilde;a actual</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-lock"></span>
                                <input type="password" class="form-control" name="pw_actual" id="menu2focus" placeholder="Contrase&ntilde;a actual" value="{$pws.pw_actual|default:''}" autofocus/>
                            </div>
                        </div>
                    </div>
                    <div class="row"></div>
                    <hr/>

                    <div class="form-group ">
                        <label for="pw_nueva" class="control-label col-md-4">Nueva Contrase&ntilde;a</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-lock"></span>
                                <input type="password" class="form-control" name="pw_nueva" id="pw_nueva" placeholder="Nueva Contrase&ntilde;a" value="{$pws.pw_nueva|default:''}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="pw_2" class="control-label col-md-4">Repetir Contrase&ntilde;a</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-lock"></span>
                                <input type="password" class="form-control" name="pw_2" id="pw_2" placeholder="Repetir Contrase&ntilde;a " value="{$pws.pw_2|default:''}" />
                            </div>
                        </div>
                    </div>

                    {if isset($_errorNum) && ($_errorNum==2)}
                        {if isset($_error)}
                            <!--Mensajes privados de cada controlador-->
                            <div class="row">
                                <div class="alert alert-danger fade in">
                                    <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error: </strong>{$_error}
                                </div>
                            </div>
                        {/if}
                    {/if}

                </div>
                <input type="submit" class="btn btn-success form-control" value="Guardar"/>
            </form>
        </div>
        <div id="menu3" class="tab-pane fade">
{*            <h3>Preferencias</h3>*}
{*            <hr/>*}
<br>
            <div class="jumbotron bg-primary">
                <h1 class="text-center text-primary">Pr&oacute;ximamente<br><small>(o no)</small></h1>
            </div>
        </div>
    </div>
</div>





