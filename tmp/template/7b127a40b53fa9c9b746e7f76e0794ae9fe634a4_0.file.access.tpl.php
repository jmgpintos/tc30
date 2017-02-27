<?php /* Smarty version 3.1.24, created on 2015-09-23 07:47:21
         compiled from "C:/xampp/htdocs/tc30/views/error/access.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:656856023ce9e4df61_29910879%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b127a40b53fa9c9b746e7f76e0794ae9fe634a4' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/error/access.tpl',
      1 => 1439902312,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '656856023ce9e4df61_29910879',
  'variables' => 
  array (
    '_mensajeerror' => 0,
    '_texto' => 0,
    'destino' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56023cea038822_10369694',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56023cea038822_10369694')) {
function content_56023cea038822_10369694 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '656856023ce9e4df61_29910879';
?>

<div class="alert alert-warning col-md-8 col-md-push-2 text-center">
    <h2>
        <span class="glyphicon glyphicon-flash text-danger"></span>
        <?php echo $_smarty_tpl->tpl_vars['_mensajeerror']->value;?>

        <span class="glyphicon glyphicon-flash text-danger"></span>
    </h2>
    <?php echo $_smarty_tpl->tpl_vars['_texto']->value;?>

<div class="btn-group  btn-group-justified btn-group-sm">
  <a href="<?php echo BASE_URL;?>
" class="btn btn-default">Ir al inicio</a>
  <a href="javascript:history.back(1)" class="btn btn-default">Volver a la p&aacute;gina anterior</a>
  <?php if (!Session::get('autenticado')) {?>
  <a href="<?php echo BASE_URL;?>
login/index/<?php echo $_smarty_tpl->tpl_vars['destino']->value;?>
" class="btn btn-default">Iniciar sesi&oacute;n</a>
  <?php }?>
</div>
</div>

<?php }
}
?>