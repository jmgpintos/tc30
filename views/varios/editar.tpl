<form id="form1" role="form" 
      class="form-horizontal well well-sm col-md-4 col-md-push-4" method="post" 
      action="">
    <input type="hidden" name="guardar" value="1" />
    <div class="form-group ">
        <label for="usuario" class="control-label col-md-3">{$nombre_campo}</label>
        <div class="col-md-9">
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-chevron-right"></span>
                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="{$placeholder}" value="{$datos.nombre|default:''}" autofocus/>
            </div>
        </div>
    </div>
    <hr>
    <a class="btn btn-warning col-md-3 col-xs-10" href="javascript:history.back(1)">Volver</a>
    <div class="col-md-9 col-xs-10">
        <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>