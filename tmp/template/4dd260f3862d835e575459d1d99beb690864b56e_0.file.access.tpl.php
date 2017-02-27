<?php /* Smarty version 3.1.24, created on 2015-09-23 17:20:06
         compiled from "F:/xampp/htdocs/tc30/views/error/access.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:195255602c326da0a86_70649348%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4dd260f3862d835e575459d1d99beb690864b56e' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/error/access.tpl',
      1 => 1439902312,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195255602c326da0a86_70649348',
  'variables' => 
  array (
    '_mensajeerror' => 0,
    '_texto' => 0,
    'destino' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602c326df2b36_94330381',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602c326df2b36_94330381')) {
function content_5602c326df2b36_94330381 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '195255602c326da0a86_70649348';
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