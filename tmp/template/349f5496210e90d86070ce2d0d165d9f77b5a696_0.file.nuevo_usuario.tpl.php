<?php /* Smarty version 3.1.24, created on 2015-09-24 09:17:51
         compiled from "C:/xampp/htdocs/tc30/views/aula_actividades/nuevo_usuario.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:135535603a39f115496_58064878%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '349f5496210e90d86070ce2d0d165d9f77b5a696' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_actividades/nuevo_usuario.tpl',
      1 => 1443079068,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '135535603a39f115496_58064878',
  'variables' => 
  array (
    'id_actividad' => 0,
    'datos' => 0,
    'sexo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603a39f16b3b2_81702867',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603a39f16b3b2_81702867')) {
function content_5603a39f16b3b2_81702867 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '135535603a39f115496_58064878';
?>
<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="<?php echo BASE_URL;?>
aula_usuarios/index/<?php echo Session::get('pagina');?>
" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="<?php echo BASE_URL;?>
aula_actividades/crearUsuario/<?php echo $_smarty_tpl->tpl_vars['id_actividad']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['datos']->value['dni'];?>
" method="post">     
            <input type="hidden" name="guardar_nuevo" value="1" />
            <div class="row col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">NIF/NIE</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Dni" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['dni'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="nombre" class="control-label col-md-3">Nombre y apellidos</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['nombre'])===null||$tmp==='' ? '' : $tmp);?>
" autofocus="">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['apellidos'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="fecha_nacimiento" class="control-label col-md-3">Fecha de Nacimiento</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="Fecha de nacimiento" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_nacimiento'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="telefono" class="control-label col-md-3">Teléfono</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-phone"></span>
                            <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['telefono'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="email" class="control-label col-md-3">e-mail</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon">@</span>

                            <input type="text" class="form-control" name="email" id="email" placeholder="Correo electrónico" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['email'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>
                        <?php $_smarty_tpl->tpl_vars['sexo'] = new Smarty_Variable((($tmp = @$_smarty_tpl->tpl_vars['datos']->value['sexo'])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                <div class="form-group ">
                    <label for="sexo" class="control-label col-md-3">Sexo</label>
                    <div class="col-md-4">
                        <div class="input-group form-inline">
                            <label class ="radio-inline control-label">
                                <input type="radio" name="sexo" value="H" 
                                       <?php if ($_smarty_tpl->tpl_vars['sexo']->value == 'H') {?>
                                           checked
                                       <?php }?>
                                       />
                                Hombre
                            </label>
                            <label class ="radio-inline control-label">
                                <input type="radio" name="sexo" value="M"
                                       <?php if ($_smarty_tpl->tpl_vars['sexo']->value == 'M') {?>
                                           checked
                                       <?php }?>
                                       />
                                Mujer
                            </label>
                        </div>
                    </div>
                    
                    


                </div>
            </div>
            <div class="row"></div>
            <a href="<?php echo BASE_URL;?>
alumno/index/<?php echo Session::get('pagina');?>
" 
               class="visible-xs col-xs-12 btn btn-warning" title="Volver sin guardar">
                Volver</a>
               <hr/>
            <input type="submit" class="visible-xs col-xs-12 pull-right  btn btn-success" value="Guardar"/>
            <input type="submit" class="hidden-xs btn btn-success form-control" value="Guardar"/>

    </div>
</form>
</div><?php }
}
?>