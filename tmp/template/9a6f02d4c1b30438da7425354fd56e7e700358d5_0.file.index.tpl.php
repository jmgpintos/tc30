<?php /* Smarty version 3.1.24, created on 2015-09-23 07:47:27
         compiled from "C:/xampp/htdocs/tc30/views/login/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1136656023cef006d70_46783253%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a6f02d4c1b30438da7425354fd56e7e700358d5' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/login/index.tpl',
      1 => 1439902314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1136656023cef006d70_46783253',
  'variables' => 
  array (
    'datos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56023cef078212_14242135',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56023cef078212_14242135')) {
function content_56023cef078212_14242135 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1136656023cef006d70_46783253';
?>
<!--<h2>Iniciar Sesi&oacute;n</h2>-->
    
<div class="row">
<form id="form1" name="form1" class="well col-md-4 col-md-push-4" method="post" action="">
    <a href="<?php echo BASE_URL;?>
" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>
    <input type="hidden" name="enviar" value="1" />
    <label for="usuario"><span class="required text-danger"></span>Usuario:</label>
    <input class="form-control " type="text" name="usuario" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['usuario'])===null||$tmp==='' ? '' : $tmp);?>
" autofocus/><p/>
<label for="password"><span class="required text-danger"></span>Contrase&ntilde;a:</label>
        <input class="form-control" type="password" name="password" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['password'])===null||$tmp==='' ? '' : $tmp);?>
"/></p>
    <hr>
    <!--<div class="col-md-9">-->
    <input type="submit" class="btn btn-success form-control" value="Conectar"/>
<!--    </div>
    <a class="btn btn-default col-md-3" href="<?php echo '<?php ';?>echo BASE_URL<?php echo '?>';?>">Salir</a>-->
</form>
</div>
    
<?php }
}
?>