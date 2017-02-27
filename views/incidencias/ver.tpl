
{if Session::accesoViewEstricto(array('admin'))}
    <div class="alert alert-warning" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <h2>Falta</h2>
        <ul>
            <li>Añadir campo técnico (ha de ser dinamizador? si no lo es, cómo se almacena en la BD?)</li>
        </ul>
    </div>
{/if}

<div class="row">
    <div class="well well-sm col-md-8 col-md-push-2">
        <a href="{BASE_URL}incidencias/index/{Session::get('pagina')}" 
           class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <div class="row col-md-12"> 
            <br/>
            <label class="control-label col-md-2">Centro</label>
            <i class="col-md-1 glyphicon glyphicon-home"></i>
            <div class="col-md-9">
                {$datos.centro|default:''}
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


            <label class="control-label col-md-2">Tipo</label>
            <i class="col-md-1 glyphicon glyphicon-chevron-right"></i>
            <div class="col-md-9">
                {$datos.txt_tipo|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Apertura:</label>
            <i class="col-md-1 glyphicon glyphicon-calendar"></i>
            <div class="col-md-9">
                {$datos.fecha_creacion|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Cierre:</label>
            <i class="col-md-1 glyphicon glyphicon-calendar"></i>
            <div class="col-md-9">
                {$datos.fecha_cierre|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Descripción:</label>
            <i class="col-md-1 glyphicon glyphicon-pencil"></i>
            <div class="col-md-9">
                {$datos.descripcion|default:''}
            </div>
            <div class="row"></div>
            <br/>

            <label class="control-label col-md-2">Solución:</label>
            <i class="col-md-1 glyphicon glyphicon-ok"></i>
            <div class="col-md-9">
                {$datos.solucion|default:''}
            </div>
            <div class="row"></div>

            <hr/>
        </div>

        <a class="col-md-4 col-md-push-4 btn btn-warning" href="{BASE_URL}incidencias/index/{Session::get('pagina')}" >Volver</a>
    </div>

</div>






