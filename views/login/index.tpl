<!--<h2>Iniciar Sesi&oacute;n</h2>-->
    
<div class="row">
<form id="form1" name="form1" class="well col-md-4 col-md-push-4" method="post" action="">
    <a href="{BASE_URL}" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>
    <input type="hidden" name="enviar" value="1" />
    <label for="usuario"><span class="required text-danger"></span>Usuario:</label>
    <input class="form-control " type="text" name="usuario" value="{$datos.usuario|default:''}" autofocus/><p/>
<label for="password"><span class="required text-danger"></span>Contrase&ntilde;a:</label>
        <input class="form-control" type="password" name="password" value="{$datos.password|default:''}"/></p>
    <hr>
    <!--<div class="col-md-9">-->
    <input type="submit" class="btn btn-success form-control" value="Conectar"/>
<!--    </div>
    <a class="btn btn-default col-md-3" href="<?php echo BASE_URL?>">Salir</a>-->
</form>
</div>
    
