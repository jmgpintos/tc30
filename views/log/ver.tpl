
{*{if Session::accesoViewEstricto(array('admin'))}
    <div class="alert alert-warning" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h2>Falta</h2>
        <ul>
            <li>Añadir campo técnico (ha de ser dinamizador? si no lo es, cómo se almacena en la BD?)</li>
        </ul>
    </div>
{/if}*}


    
    {* array(1) {
  [0]=>
  array(10) {
    ["id"]=>
    string(3) "101"
    ["nivel"]=>
    string(1) "6"
    ["tiempo"]=>
    string(19) "2015-09-03 12:42:51"
    ["id_usuario"]=>
    string(2) "17"
    ["ip"]=>
    string(3) "::1"
    ["equipo"]=>
    string(12) "oficina05-PC"
    ["metodo"]=>
    string(21) "Model::editarRegistro"
    ["tabla"]=>
    string(13) "tc30_usuarios"
    ["mensaje"]=>
    string(16) "registro editado"
    ["contexto"]=>
    string(56) "[campos=>[ultimo_acceso=>2015-09-03 12:42:51], [id=>17]]"
  }
}*}
     

<div class="row">
    <div class="well well-sm col-md-8 col-md-push-2">
        <a href="{BASE_URL}log/index/{Session::get('pagina')}" 
           class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <div class="row col-md-12"> 
            <br/>
            <label class="control-label col-md-2">Nivel</label>
            <i class="col-md-1 glyphicon glyphicon-home"></i>
            <div class="col-md-9">
                {$datos.nivel|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Equipo</label>
            <i class="col-md-1 glyphicon glyphicon-console"></i>
            <div class="col-md-9">
                {$datos.equipo|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">ip</label>
            <i class="col-md-1 glyphicon glyphicon-chevron-right"></i>
            <div class="col-md-9">
                {$datos.ip|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Tiempo:</label>
            <i class="col-md-1 glyphicon glyphicon-time"></i>
            <div class="col-md-9">
                {$datos.tiempo|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Mensaje:</label>
            <i class="col-md-1 glyphicon glyphicon-calendar"></i>
            <div class="col-md-9">
                {$datos.mensaje|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">M&eacute;todo:</label>
            <i class="col-md-1 glyphicon glyphicon-pencil"></i>
            <div class="col-md-9">
                {$datos.metodo|default:''}
            </div>
            <div class="row"></div>
            <br/>

            <label class="control-label col-md-2">Contexto:</label>
            <i class="col-md-1 glyphicon glyphicon-ok"></i>
            <div class="col-md-9">
                {$datos.contexto|default:''}
            </div>
            <div class="row"></div>

            <hr/>
        </div>

        <a class="col-md-4 col-md-push-4 btn btn-warning" href="{BASE_URL}log/index/{Session::get('pagina')}" >Volver</a>
    </div>

</div>






