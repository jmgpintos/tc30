<?php /* Smarty version 3.1.24, created on 2015-09-24 12:35:48
         compiled from "C:/xampp/htdocs/tc30/views/aula_responsables/editar.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:41845603d2049de406_02169108%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2fcff1ffbd1c2468172f8b107b515dff5258b7ab' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_responsables/editar.tpl',
      1 => 1443090947,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '41845603d2049de406_02169108',
  'variables' => 
  array (
    'datos' => 0,
    'sexo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603d204a43d16_94135719',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603d204a43d16_94135719')) {
function content_5603d204a43d16_94135719 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '41845603d2049de406_02169108';
?>
<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="<?php echo BASE_URL;?>
aula_usuarios/index/<?php echo Session::get('pagina');?>
" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
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
">
                            <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Apellidos" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['apellidos'])===null||$tmp==='' ? '' : $tmp);?>
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