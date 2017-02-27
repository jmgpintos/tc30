<?php /* Smarty version 3.1.24, created on 2015-09-23 17:14:26
         compiled from "F:/xampp/htdocs/tc30/views/index/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:131885602c1d2e4bdf0_76071650%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5750b0e5801fa32ddbd09d4ff23e041dd95a4627' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/index/index.tpl',
      1 => 1442211872,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131885602c1d2e4bdf0_76071650',
  'variables' => 
  array (
    '_layoutParams' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602c1d2e598b8_49904209',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602c1d2e598b8_49904209')) {
function content_5602c1d2e598b8_49904209 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '131885602c1d2e4bdf0_76071650';
?>


<img class="center-block img-responsive img-thumbnail " src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
logo_telecentros.png" />
 <?php if (Session::accesoViewEstricto(array('especial'))) {?>
<a class="btn btn-primary btn-round" title="Crear nuevo" href="<?php echo BASE_URL;?>
index/verTablas"><i class="glyphicon glyphicon-certificate"></i></a>
    <a class="btn btn-primary btn-round" title="Crear nenes" href="<?php echo BASE_URL;?>
index/p"><i class="glyphicon glyphicon-dashboard"></i></a>
<?php }?>
 <?php }
}
?>