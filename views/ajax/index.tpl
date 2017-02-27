<h2>Ejemplo de AJAX</h2>
<form class="col-md-5 well form-horizontal">
    <div class="form-group">
        <label class="col-md-4 text-right control-label"> Centros:</label>
        <div class="col-md-8">
            <select class="form-control" id="centro">
                <option value=""> -seleccione- </option>
                {foreach from=$centros item=p}          
                    <option value="{$p.id}">{$p.nombre}</option>
                {/foreach}
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 text-right control-label">Usuarios:</label>
        <div class="col-md-8">
            <select class="col-md-8 form-control" id="usuario"></select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 text-right control-label">Ciudad a insertar:</label>
        <div class="col-md-8">
            <input class="col-md-8 form-control" type="text" id="ins_ciudad"/>
        </div>
    </div>
    <input class="btn btn-success form-control" type="button" value="insertar" id="btn_insertar" />
</form>