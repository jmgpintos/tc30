<?php /* Smarty version 3.1.24, created on 2015-09-23 17:14:29
         compiled from "F:/xampp/htdocs/tc30/views/login/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:218175602c1d56f82b1_27016500%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a761ddeae2201b2e10340d12beb057d5d70c8bd' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/login/index.tpl',
      1 => 1439902314,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '218175602c1d56f82b1_27016500',
  'variables' => 
  array (
    'datos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602c1d574a361_41471986',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602c1d574a361_41471986')) {
function content_5602c1d574a361_41471986 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '218175602c1d56f82b1_27016500';
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