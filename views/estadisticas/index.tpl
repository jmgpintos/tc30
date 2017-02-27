
    


<div class="row">

    <form class="" action="" method="post" >

        <input type="hidden" name="guardar" value="1">
        <div class="row">
            <div class="alert alert-info col-md-8 col-md-push-2">

                <div class="col-md-3 text-center">
                    <div class="form-group">
                        <label class="control-label" for="desde">Desde</label>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                                   value="{$datos.desde|default:''}">
                        </div>     
                    </div>
                </div>

                <div class="col-md-3 col-md-push-1 text-center">
                    <div class="form-group">
                        <label  class="control-label" for="hasta">Hasta</label>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd" 
                                   value="{$datos.hasta|default:''}" >
                        </div>                                
                    </div>                                
                </div>
                <br/>
                <div class="alert alert-info col-md-4 text-center form-group pull-right">

                    <input type="checkbox" name="outPDF" id="outPDF" autocomplete="off"
                           {if isset($datos.outPDF)}
                               checked=""
                           {/if}
                           />
                    <div class="btn-group">
                        <label for="outPDF" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok"></span>
                            <span> </span>
                        </label>
                        <label for="outPDF" class="btn btn-default active">
                            PDF
                        </label>
                    </div>
                        
                    <div class="btn-group">
                        <input type="checkbox" name="outXLS" id="outXLS" autocomplete="off"
                           {if isset($datos.outXLS)}
                               checked=""
                           {/if}
                           />
                        <div class="btn-group">
                            <label for="outXLS" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                <span> </span>
                            </label>
                            <label for="outXLS" class="btn btn-default active">
                                XLS
                            </label>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default col-md-10 col-md-push-1">
                <div class="panel-heading">
                    <h3 class="text-primary">Seleccione estad&iacute;sticas para consultar</h3>
                </div>
                <div id="SQLs" class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            {foreach from=$metodos_sql1 item=item}
                                <div >
                                    <input type="checkbox" id ="SQL{$item.id}" value="{$item.id}" name="checkbox[]"
                                           {if (isset($seleccionados))}
                                               {if $item.id|in_array:$seleccionados}checked=""{/if}
                                           {/if}
                                           >
                                    <label for="SQL{$item.id}">
                                        {$item.nombre}
                                    </label>
                                </div>
                            {/foreach}

                        </div>
                        <div class="col-md-6">
                            {foreach from=$metodos_sql2 item=item}
                                <div >
                                    <input type="checkbox" id ="SQL{$item.id}" value="{$item.id}" name="checkbox[]"
                                           {if (isset($seleccionados))}
                                               {if $item.id|in_array:$seleccionados}checked=""{/if}
                                           {/if}
                                           >
                                    <label for="SQL{$item.id}">
                                        {$item.nombre}
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12 text-center">

                            <a class="btn btn-info btn-sm" id="btnseleccionarTodos" onclick="seleccionarTodos()">seleccionar Todos</a>
                            <a class="btn btn-info btn-sm" id="btnseleccionarNinguno" onclick="seleccionarNinguno()">seleccionar Ninguno</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <input class="form-control btn btn-primary" type="submit" value="Enviar">
            </form>
        </div>