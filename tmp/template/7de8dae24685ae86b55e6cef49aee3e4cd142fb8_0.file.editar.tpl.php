<?php /* Smarty version 3.1.24, created on 2015-09-24 11:32:28
         compiled from "C:/xampp/htdocs/tc30/views/aula_actividades/editar.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:161015603c32c744cb1_86605499%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7de8dae24685ae86b55e6cef49aee3e4cd142fb8' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_actividades/editar.tpl',
      1 => 1443087147,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161015603c32c744cb1_86605499',
  'variables' => 
  array (
    'datos' => 0,
    'tipos' => 0,
    'tipo' => 0,
    'responsables' => 0,
    'responsable' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603c32c79ea41_05882669',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603c32c79ea41_05882669')) {
function content_5603c32c79ea41_05882669 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '161015603c32c744cb1_86605499';
if (Session::accesoViewEstricto(array('admin'))) {?>
    
<?php }?>

<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  

                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-tag"></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['nombre'])===null||$tmp==='' ? '' : $tmp);?>
" autofocus/>

                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <label for="id_tipo" class="control-label col-md-3">Tipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_tipo" name="id_tipo" autofocus>
                                <?php
$_from = $_smarty_tpl->tpl_vars['tipos']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['tipo'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['tipo']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['tipo']->value) {
$_smarty_tpl->tpl_vars['tipo']->_loop = true;
$foreach_tipo_Sav = $_smarty_tpl->tpl_vars['tipo'];
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['tipo']->value['id'];?>
"
                                            <?php if ((isset($_smarty_tpl->tpl_vars['datos']->value['id_tipo']))) {?>
                                                <?php if (($_smarty_tpl->tpl_vars['datos']->value['id_tipo'] == $_smarty_tpl->tpl_vars['tipo']->value['id'])) {?>
                                                    selected="selected"
                                                <?php }?>
                                            <?php }?>><?php echo $_smarty_tpl->tpl_vars['tipo']->value['nombre'];?>
</option>
                                <?php
$_smarty_tpl->tpl_vars['tipo'] = $foreach_tipo_Sav;
}
?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="id_responsable" class="control-label col-md-3">Tipo</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_responsable" name="id_responsable" autofocus>
                                <?php
$_from = $_smarty_tpl->tpl_vars['responsables']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['responsable'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['responsable']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['responsable']->value) {
$_smarty_tpl->tpl_vars['responsable']->_loop = true;
$foreach_responsable_Sav = $_smarty_tpl->tpl_vars['responsable'];
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['responsable']->value['id'];?>
"
                                            <?php if ((isset($_smarty_tpl->tpl_vars['datos']->value['id_responsable']))) {?>
                                                <?php if (($_smarty_tpl->tpl_vars['datos']->value['id_responsable'] == $_smarty_tpl->tpl_vars['responsable']->value['id'])) {?>
                                                    selected="selected"
                                                <?php }?>
                                            <?php }?>><?php echo $_smarty_tpl->tpl_vars['responsable']->value['nombre'];?>
</option>
                                <?php
$_smarty_tpl->tpl_vars['responsable'] = $foreach_responsable_Sav;
}
?>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="descripcion" class=" col-md-12">Descripci&oacute;n</label>
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-list-alt"></span>
                            <textarea class="form-control" id="descripcion" name="descripcion"
                                      rows="5"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['descripcion'])===null||$tmp==='' ? '' : $tmp);?>

                            </textarea>
                        </div>
                    </div>
                </div>
                <hr/>

                <div class="form-group col-md-4 col-md-push-2">
                    <label for="fecha_inicio">Fecha inicio</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_inicio'])===null||$tmp==='' ? '' : $tmp);?>
">
                    </div>

                    <label for="fecha_fin" >Fecha fin</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_fin'])===null||$tmp==='' ? '' : $tmp);?>
">
                    </div>
                </div>

                <div class="form-group  col-md-4 pull-right">
                    <label for="hora_inicio">Hora inicio</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-time"></span>
                        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora_inicio'])===null||$tmp==='' ? '' : $tmp);?>
">
                    </div>

                    <label for="hora_fin">Hora fin</label><br/>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-time"></span>
                        <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora_fin'])===null||$tmp==='' ? '' : $tmp);?>
">
                    </div>
                </div>

            </div>
            <input type="submit" class="btn btn-success form-control" value="Guardar"/>
    </div>
</form>

</div>

                    <?php }
}
?>