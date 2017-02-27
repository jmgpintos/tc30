<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="{BASE_URL}aula_usuarios/index/{Session::get('pagina')}" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">NIF/NIE</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Dni" value="{$datos.dni|default:''}">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre y apellidos</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{$datos.nombre|default:''}">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="{$datos.apellidos|default:''}">
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
                    <label for="email" class="control-label col-md-3">e-mail</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">@</span>
{*                            <span class="input-group-addon glyphicon glyphicon-"></span>*}
                            <input type="text" class="form-control" name="email" id="email" placeholder="Correo electrónico" value="{$datos.email|default:''}">
                        </div>
                    </div>
                </div>
                        {$sexo = $datos.sexo|default:''}
                <div class="form-group ">
                    <label for="sexo" class="control-label col-md-3">Sexo</label>
                    <div class="col-md-4">
                        <div class="input-group form-inline">
                            <label class ="radio-inline control-label">
                                <input type="radio" name="sexo" value="H" 
                                       {if $sexo=='H'}
                                           checked
                                       {/if}
                                       />
                                Hombre
                            </label>
                            <label class ="radio-inline control-label">
                                <input type="radio" name="sexo" value="M"
                                       {if $sexo=='M'}
                                           checked
                                       {/if}
                                       />
                                Mujer
                            </label>
                        </div>
                    </div>
                    {*                </div>*}
                    {*                <div class="form-group text-right">*}


                </div>
            </div>
            <div class="row"></div>
            <a href="{BASE_URL}alumno/index/{Session::get('pagina')}" 
               class="visible-xs col-xs-12 btn btn-warning" title="Volver sin guardar">
                Volver</a>
               <hr/>
            <input type="submit" class="visible-xs col-xs-12 pull-right  btn btn-success" value="Guardar"/>
            <input type="submit" class="hidden-xs btn btn-success form-control" value="Guardar"/>

    </div>
</form>
</div>