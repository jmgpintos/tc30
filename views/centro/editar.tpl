<div class="row">
    <div class="well well-sm col-md-8 col-md-push-2">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form role="form" class="form-horizontal" action="" method="post"  enctype="multipart/form-data">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">
                    
                    <div class="form-group ">
                        <label for="nombre" class="control-label col-md-3">Nombre</label>
                        <div class="col-md-9">
                            <div class="input-group form-inline">
                                <span class="input-group-addon glyphicon glyphicon-home"></span>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="{$datos.nombre|default:''}" autofocus="">
                            </div>
                        </div>
                    </div>
                            
                    <div class="form-group ">
                        <label for="direccion" class="control-label col-md-3">Direcci&oacute;n</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-globe"></span>
                                <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección" value="{$datos.direccion|default:''}">
                            </div>
                        </div>
                    </div>
                            
                    <div class="form-group ">
                        <label for="telefono" class="control-label col-md-3">Tel&eacute;fono</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-phone"></span>
                                <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="{$datos.telefono|default:''}">
                            </div>
                        </div>
                    </div>
                            
                    <div class="form-group ">
                        <label for="aforo" class="control-label col-md-3">Aforo</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-user"></span>
                                <input type="text" class="form-control" name="aforo" id="aforo" placeholder="Aforo" value="{$datos.aforo|default:''}">
                            </div>
                        </div>
                    </div>                                        
                            
                    <div class="form-group ">
                        <label for="fundacion" class="control-label col-md-3">Fundaci&oacute;n</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="text" class="form-control" name="fundacion" id="fundacion" placeholder="A&ntilde;o de fundaci&oacute;n" value="{$datos.fundacion|default:''}">
                            </div>
                        </div>
                    </div>                                        

                    <div class="form-group ">
                        <label for="coordenadas" class="control-label col-md-3">Coordenadas</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-globe"></span>
                                
                                <textarea class="form-control" name="coordenadas" id="coordenadas" 
                                       placeholder="Coordenadas" >{$datos.coordenadas|default:''}</textarea>
                            </div>
                        </div>
                    </div>                            

                    <div class="form-group ">
                        <label for="mapa" class="control-label col-md-3">Mapa</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-globe"></span>
                                <textarea class="form-control" name="mapa" id="mapa" 
                                       placeholder="Mapa" rows="5">{$datos.mapa|default:''}</textarea>
                            </div>
                        </div>
                    </div>


            <input type="submit" class="btn btn-success form-control" style="margin: 5px" value="Guardar"/>
    </div>
</div>
</form>
</div>