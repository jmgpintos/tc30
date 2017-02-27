<?php /* Smarty version 3.1.24, created on 2015-09-24 08:36:38
         compiled from "C:/xampp/htdocs/tc30/views/index/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:3456560399f66f1a63_56331497%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41bf5fda2ce83fa32b577d22bee95b57c9aa93b7' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/index/index.tpl',
      1 => 1442211872,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3456560399f66f1a63_56331497',
  'variables' => 
  array (
    '_layoutParams' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_560399f6728577_50810236',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_560399f6728577_50810236')) {
function content_560399f6728577_50810236 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '3456560399f66f1a63_56331497';
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