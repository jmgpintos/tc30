<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form role="form" class="form-horizontal" action="{BASE_URL}acceso_libre/nuevoUsuarioAccesoLibre/{$datos.dni|default:''}" method="post">     
            <input type="hidden" name="guardar_nuevo_usuario" value="1" />
            <div class="row col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">DNI</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="DNI" value="{$dni|default:''}" disabled>
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
                    <label for="fechaNac" class="control-label col-md-3">Fecha de Nacimiento</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fechaNac" id="fechaNac" placeholder="Fecha de nacimiento" value="{$datos.fechaNac|default:''}">
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
                    <label for="sexo" class="control-label col-md-3">Sexo</label>
                    <div class="col-md-4">
                        <div class="input-group form-inline">
                            <label class ="radio-inline control-label"><input type="radio" name="sexo" value="Hombre">Hombre</label>
                            <label class ="radio-inline control-label"><input type="radio" name="sexo" value="Mujer">Mujer</label>
                        </div>
                    </div>
                    <div class="col-md-5 text-right">
                        <input type="checkbox" name="discapacitado" id="discapacitado" autocomplete="off"/>
                        <div class="btn-group">
                            <label for="discapacitado" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                <span> </span>
                            </label>
                            <label for="discapacitado" class="btn btn-default active">
                                Discapacitado
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</div>
</form>
</div>