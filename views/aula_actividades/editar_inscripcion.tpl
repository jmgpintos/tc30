{if Session::accesoViewEstricto(array('admin'))}
    {*<div class="alert alert-warning" role="alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h2>Falta javascript</h2>
    <ul>
    <li>Actualizar profesor al elegir centro</li>
    </ul>
    </div>*}
{/if}

{*
["id_usuario"]=> string(2) "35"
["id_actividad"]=> string(1) "1"
["asistencia"]=> string(1) "0"
["notas"]=> NULL
["nombre_actividad"]=> string(32) "El WiFi y la madre que lo parió"
["usuario"]=> string(25) "Pérez Hernández, Daniel"
["horas"]=> string(11) "A confirmar"
["fechas_largo"]=> string(11) "A confirmar"
["fechas"]=> string(11) "A confirmar"
["pendiente"]=> bool(true)
*}

<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <div class="row col-md-12"> 
            <br/>

            <label class="control-label col-md-2">Tipo:</label>
            <i class="col-md-1 glyphicon glyphicon-th-large"></i>
            <div class="col-md-9">
                {$datos.tipo_actividad|default:''}
            </div>
            <div class="row"></div>
            <br/>

            <label class="control-label col-md-2">Nombre</label>
            <i class="col-md-1 glyphicon glyphicon-chevron-right"></i>
            <div class="col-md-9">
                {$datos.nombre_actividad|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Fechas</label>
            <i class="col-md-1 glyphicon glyphicon-calendar"></i>
            <div class="col-md-9">
                {$datos.fechas_largo|default:''}
            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Horario</label>
            <i class="col-md-1 glyphicon glyphicon-time"></i>
            <div class="col-md-9">
                {$datos.horas|default:''}
            </div>
            <div class="row"></div>
            <hr/>


            <label class="control-label col-md-2">Usuario:</label>
            <i class="col-md-1 glyphicon glyphicon-user"></i>
            <div class="col-md-9">
                {$datos.usuario|default:''}
            </div>
            <div class="row"></div>

            <hr/>
        </div>





        <hr>
        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  



                <div class="form-group ">
                    <label for="descripcion" class="col-md-3">Notas</label>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-list-alt"></span>
                            <textarea class="form-control" id="notas" name="notas"
                                      rows="5">{$datos.notas|default:''}
                            </textarea>
                        </div>
                    </div>
                </div>
                <hr/>



                <div class="row">
                    <div class="form-group  col-md-12 text-right">
                        <input type="checkbox" name="asistencia" id="asistencia" autocomplete="off"
                               {if isset($datos.asistencia) && $datos.asistencia==1}
                                   checked
                               {/if}
                               />
                        <div class="btn-group">
                            <label for="asistencia" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                <span> </span>
                            </label>
                            <label for="asistencia" class="btn btn-default active">
                                Asistencia
                            </label>
                        </div>
                    </div>
                </div>     




            </div>
            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>

</div>
