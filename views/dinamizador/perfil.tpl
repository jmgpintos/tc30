<div class="row">
    <div class="well well-sm col-md-8 col-md-push-2">
        <a href="{BASE_URL}dinamizador/index/{Session::get('pagina')}" 
           class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form  role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />


            <div class="alert  small text-center col-md-3">
                {if (isset($datos.imagen) && $datos.imagen!='')}
                    <img src='{$_layoutParams.root}public/img/profiles/users/{$datos.imagen}'/>
                {else}
                    <img src='{$_layoutParams.root}public/img/profiles/users/{DEFAULT_USER_IMG}'/>
                    El archivo debe ser blablabla... Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                {/if}
                <!-- image-preview-filename input [CUT FROM HERE]-->
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                            <span class="glyphicon glyphicon-remove"></span> {*Clear*}
                        </button>
                        <!-- image-preview-input -->
                        <div class="btn btn-default image-preview-input">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            {*                                <span class="image-preview-input-title">Browse</span>*}
                            <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
                        </div>
                    </span>
                </div><!-- /input-group image-preview [TO HERE]--> 
            </div>
            <div class="row col-md-9">  
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
                <div class="form-group">
                    <label for="email" class="control-label col-md-3">e-mail</label>
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
                    <label for="telefono" class="control-label col-md-3"></label>
                    <div class="col-md-9">
                        <a 
                            class="btn btn-warning form-control"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-restablecer-pw" 
                            data-href="{BASE_URL}{$controlador}/resetPW/{$datos.id}" 
                            title="Restablecer contrase&ntilde;a del usuario">
                            <i class=" glyphicon glyphicon-refresh"></i>
                            Restablecer contrase&ntilde;a
                        </a>
{*                    <a class="btn btn-warning btn-sm center-block" href="#">Restablecer contrase&ntilde;a</a>*}
                    </div>
                </div>
<hr/>


                {if Session::accesoView('especial')}

                    <div class="form-group ">
                        <label for="centro" class="control-label col-md-3">Centro</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-home"></span>
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




                    <div class="col-md-12">

                        <div class="form-group" >
                            <label for="fun" class="col-md-3 control-label text-right">Rol</label>
                            {*                    <div class="col-sm-7 col-md-5">*}
                            <div class="input-group col-md-7" >
                                <div id="radioBtn" class="btn-group">

                                    <a class="btn btn-default btn-sm 
                                       {if ($datos.role=="aula_innova")}
                                           active
                                       {else}
                                           notActive
                                       {/if}
                                       " data-toggle="role" 
                                       data-title="aula_innova"  
                                       >Aula Innova</a>
                                    <a class="btn btn-default btn-sm 
                                       {if ($datos.role=="usuario")}
                                           active
                                       {else}
                                           notActive
                                       {/if}
                                       " data-toggle="role" 
                                       data-title="usuario"  
                                       >Usuario</a>
                                    <a class="btn btn-default btn-sm 
                                       {if ($datos.role=="especial")}
                                           active
                                       {else}
                                           notActive
                                       {/if}" data-toggle="role" 
                                       data-title="especial">Especial</a>
                                    <a class="btn btn-default btn-sm 
                                       {if ($datos.role=="admin")}
                                           active
                                       {else}
                                           notActive
                                       {/if}" data-toggle="role" 
                                       data-title="admin">Admin</a>
                                </div>
                                <input type="hidden" name="role" id="role" value="{$datos.role}">
                            </div>
                            {*                    </div>*}
                        </div>

                        <div class="col-md-4 pull-right">

                            <div class="form-group text-right">
                                <input type="checkbox" name="estado" id="estado" autocomplete="off"
                                       {if isset($datos.estado) && $datos.estado==1}
                                           checked
                                       {/if}
                                       />
                                <div class="btn-group">
                                    <label for="estado" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-ok"></span>
                                        <span> </span>
                                    </label>
                                    <label for="estado" class="btn btn-default active">
                                        Activo
                                    </label>
                                </div>
                            </div>
                        </div>

                    {/if}

                </div>
                {*<div class="form-group col-md-4 text-right pull-right">
                    <input type="checkbox" name="estado" id="estado" autocomplete="off"
                           {if isset($datos.estado) && $datos.estado==1}
                               checked
                           {/if}
                           />
                    <div class="btn-group">
                        <label for="estado" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok"></span>
                            <span> </span>
                        </label>
                        <label for="estado" class="btn btn-default active">
                            Activo
                        </label>
                    </div>
                </div>*}

            </div>
                    <hr/>

            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
        </form>
    </div>
</div>





<!--modal #confirmar-restablecer-pw-->
<div class="modal fade" id="confirmar-restablecer-pw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog {*modal-sm*}">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo-modal"></h4>
            </div>
            <div class="modal-body">
                La contrase&ntilde;a se restablecerá a la contrase&ntilde;a por defecto ({DEFAULT_PASSWORD})
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-warning btn-ok">Aceptar</a>
            </div>
        </div>
    </div>
</div>
