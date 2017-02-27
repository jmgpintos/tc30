<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="{BASE_URL}acceso_libre/index" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">Centro</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-home"></span>
                            <input type="text" class="form-control" name="centro" id="centro" placeholder="Dni" value="{$centro|default:''}" disabled>
                            {*
                            <select class='form-control' name="centro" onchange="this.form.submit()">
                            {foreach from=$centros item=item}
                            {if ($centro == $item.id)}
                            <option value='{$item.id}' selected>{$item.nombre}</option>
                            {else}
                            <option value='{$item.id}' >{$item.nombre}</option>
                            {/if}
                            {/foreach}
                            </select>*}
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">Equipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-console"></span>
                            <select class='form-control' name="equipo">
                                {foreach from=$equiposLibres item=item}
                                    {if isset($equipo) && $equipo == $item.id}
                                        <option value='{$item.id}' selected>{$item.nombre}</option>
                                    {else}
                                        <option value='{$item.id}' >{$item.nombre}</option>
                                    {/if}
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">NIF/NIE</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Dni" value="{$dni|default:''}" autofocus>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row"></div>
            <a href="javascript:history.back();" 
               class="hidden-md hidden-lg col-xs-5 btn btn-warning" title="Volver sin guardar">
                Volver</a>
            <input type="submit" class="hidden-md hidden-lg col-xs-5 pull-right  btn btn-success" value="Continuar"/>
            <input type="submit" class="visible-lg btn btn-success form-control" value="Continuar"/>

    </div>
</form>
</div>