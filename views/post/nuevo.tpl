<form id="form1" class="col-md-12" method="post" action="{BASE_URL}post/nuevo" enctype="multipart/form-data">
    <input type="hidden" name="guardar" value="1" />
    <div class="col-md-8" id="izq">
        <p>Título:<br/>
            <input class="form-control" type="text" name="titulo" value="{$datos.titulo|default:''}"/></p>
        <p>Cuerpo:<br/>
            <textarea rows="10" class="form-control" name="cuerpo">{$datos.cuerpo|default:''}</textarea>    
    </div>
    <div class="col-md-4" id="der" style="margin:15px 0;">
        <div class="alert alert-info small text-center" style="height: 100%;">
            {if isset($datos.imagen)}
                    <img src='{$_layoutParams.root}public/img/post/thumb/{$datos.imagen}'/>
            {else}
                    <img id="default_img" width="250px" src='{$_layoutParams.root}public/img/post/{DEFAULT_POST_IMG}'/>
            {/if}
            <div  style="vertical-align: bottom">
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
                    <span class="input-group-btn">
                        <!-- image-preview-clear button -->
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                            <span class="glyphicon glyphicon-remove"></span> {*Clear*}
                        </button>
                        <!-- image-preview-input -->
                        <div class="btn btn-default image-preview-input">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            {*                                <span class="image-preview-input-title">Browse</span>*}
                            <input type="file" accept="image/png, image/jpeg, image/gif" name="imagen"/> <!-- rename it -->
                        </div>
                    </span>
                </div>
                La imagen debe ser blablabla... Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </div>
        </div>
    </div>
    <script type="text/javascript">
        console.log('izq: ' + $('#izq').height());
        console.log('der: ' + $('#der').height());
        $("#der").height($('#izq').height());
        console.log('der: ' + $('#der').height());
    </script>
    <div class="col-md-9">
        <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
    <a class="btn btn-default col-md-3" href="javascript:history.back(1)">Volver</a>
</form>