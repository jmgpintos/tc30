<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="{BASE_URL}curso/index/{Session::get('pagina')}" 
           class="close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  

                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del curso" value="{$datos.nombre|default:''}" autofocus>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="categoria" class="control-label col-md-3">Categor&iacute;a</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-th"></span>
                            <select class="form-control" name="id_categoria" id="categoria" placeholder="Categoría" value="">
                                {foreach from=$categorias item=cat}
                                    <option value='{$cat.id}'>{$cat.nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="descripcion" class="control-label col-md-3">Descripción</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-tag"></span>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="5" placeholder="Descripción" value="">{$datos.descripcion|default:''}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="requisitos" class="control-label col-md-3">Requisitos</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-list-alt"></span>
                            <input type="text" class="form-control" name="requisitos" id="requisitos" placeholder="Requisitos" value="{$datos.requisitos|default:''}">
                        </div>
                    </div>
                </div>
                {if isset($titulo) && $titulo=='Nuevo Curso'}
                    <div class="form-group col-md-9 col-md-push-3">
                        <input type="checkbox" name="especial" id="especial" autocomplete="off"
                               {if isset($datos.especial) && $datos.especial==1}
                                   checked
                               {/if}
                               />
                        <div class="btn-group">
                            <label for="especial" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                <span> </span>
                            </label>
                            <label for="especial" class="btn btn-default active">
                                Especial
                            </label>
                        </div>
                    </div>
                {/if}

                <input type="submit" class="btn btn-success form-control" value="Guardar"/>
            </div>

    </div>
</form>
</div>
                