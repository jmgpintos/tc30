<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="{BASE_URL}incidencias/index/{Session::get('pagina')}" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <div class="row col-md-12">  

            <br/>
            <label class="col-md-3 text-right">Centro</label>
            <div class="col-md-9">
                <i class="glyphicon glyphicon-home"></i>
                {$datos.centro|default:''}
            </div>
            <div class="row"></div>
            <br/>

            <label class="col-md-3 text-right">Equipo</label>
            <div class="col-md-9">
                <i class="glyphicon glyphicon-console"></i>
                {$datos.equipo|default:''}
            </div>
            <div class="row"></div>
            <br/>

            <label class="col-md-3 text-right">Tipo</label>
            <div class="col-md-9">
                <i class="glyphicon glyphicon-chevron-right"></i>
                {$datos.txt_tipo|default:''}
            </div>
            <div class="row"></div>

            <hr/>

            <form role="form" class="form-horizontal" action="" method="post"> 
            <input type="hidden" name="guardar" value="1" />    

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
                            <input type="date" class="form-control" name="fecha_cierre" id="fecha_cierre" placeholder="aaaa-mm-dd" value="{$datos.fecha_cierre|default:''}">
                        </div>
                    </div>
                </div>

                <a href="{BASE_URL}incidencias/index/{Session::get('pagina')}" 
                   class="hidden-md hidden-lg col-xs-5 btn btn-warning" title="Volver sin guardar">
                    Volver</a>
                <input type="submit" class="hidden-md hidden-lg col-xs-5 pull-right  btn btn-success" value="Guardar"/>
                <input type="submit" class="visible-lg btn btn-success form-control" value="Guardar"/>

            </form>
        </div>
    </div>
</div>