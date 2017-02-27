<?php /* Smarty version 3.1.24, created on 2015-09-24 20:17:26
         compiled from "F:/xampp/htdocs/tc30/views/layout/default/template.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:25056043e369b62a3_86498359%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f305bcdaa696460405d38d058ba4ac22e0d6b85f' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/layout/default/template.tpl',
      1 => 1443099316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25056043e369b62a3_86498359',
  'variables' => 
  array (
    'titulo' => 0,
    '_layoutParams' => 0,
    'menu' => 0,
    '_clase' => 0,
    'sub' => 0,
    'cuenta' => 0,
    'error' => 0,
    'mensaje' => 0,
    '_contenido' => 0,
    'js' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56043e36c7f254_45809489',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56043e36c7f254_45809489')) {
function content_56043e36c7f254_45809489 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '25056043e369b62a3_86498359';
?>
	
<!DOCTYPE html>
<html lang="es" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo (($tmp = @strip_tags($_smarty_tpl->tpl_vars['titulo']->value))===null||$tmp==='' ? $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_name'] : $tmp);?>
</title>
        
        <!--<link rel="stylesheet" href="<?php echo '<?php ';?>echo $_layoutParams['ruta_css'] <?php echo '?>';?>estilo.css">-->
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_css'];?>
bootstrap.css">
        
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_css'];?>
font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_css'];?>
estilo.css">
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_css'];?>
jquery-ui.css">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
agencia.ico">
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
"><span class="label label-default text-default"><?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_name'];?>
</span></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['menu'])) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['_layoutParams']->value['menu'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menu']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
$foreach_menu_Sav = $_smarty_tpl->tpl_vars['menu'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['menu']->value['id'] == 'separador') {?>
                                <li role="separator" class="divider"></li>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['submenu'])) {?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['item']) && $_smarty_tpl->tpl_vars['_layoutParams']->value['item'] == $_smarty_tpl->tpl_vars['menu']->value['id']) {?>
                                            <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('active', null, 0);?>
                                        <?php } else { ?>
                                            <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('', null, 0);?>
                                        <?php }?>
                                    <li class="<?php echo $_smarty_tpl->tpl_vars['_clase']->value;?>
 dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['titulo'];?>

                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php
$_from = $_smarty_tpl->tpl_vars['menu']->value['submenu'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sub']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->_loop = true;
$foreach_sub_Sav = $_smarty_tpl->tpl_vars['sub'];
?>
                                                <?php if ($_smarty_tpl->tpl_vars['sub']->value['id'] == 'separador') {?>
                                                    <li role="separator" class="divider"></li>
                                                    <?php } else { ?>
                                                    <li ><a href="<?php echo $_smarty_tpl->tpl_vars['sub']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['sub']->value['titulo'];?>
</a></li>
                                                    <?php }?>
                                                <?php
$_smarty_tpl->tpl_vars['sub'] = $foreach_sub_Sav;
}
?>
                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['item']) && $_smarty_tpl->tpl_vars['_layoutParams']->value['item'] == $_smarty_tpl->tpl_vars['menu']->value['id']) {?>
                                        <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('active', null, 0);?>
                                    <?php } else { ?>
                                        <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('', null, 0);?>
                                    <?php }?>
                                    <li class="<?php echo $_smarty_tpl->tpl_vars['_clase']->value;?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['titulo'];?>
</a></li>
                                    <?php }?>
                                <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['menu'] = $foreach_menu_Sav;
}
?>
                        <?php }?>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['menu_right'])) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['_layoutParams']->value['menu_right'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menu']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['menu']->value) {
$_smarty_tpl->tpl_vars['menu']->_loop = true;
$foreach_menu_Sav = $_smarty_tpl->tpl_vars['menu'];
?>
                            <?php if ($_smarty_tpl->tpl_vars['menu']->value['id'] == 'separador') {?>
                                <li role="separator" class="divider"></li>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['menu']->value['submenu'])) {?>
                                        <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['item']) && $_smarty_tpl->tpl_vars['_layoutParams']->value['item'] == $_smarty_tpl->tpl_vars['menu']->value['id']) {?>
                                            <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('active', null, 0);?>
                                        <?php } else { ?>
                                            <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('', null, 0);?>
                                        <?php }?>
                                    <li class="<?php echo $_smarty_tpl->tpl_vars['_clase']->value;?>
 dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['titulo'];?>

                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <?php
$_from = $_smarty_tpl->tpl_vars['menu']->value['submenu'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['sub'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['sub']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['sub']->value) {
$_smarty_tpl->tpl_vars['sub']->_loop = true;
$foreach_sub_Sav = $_smarty_tpl->tpl_vars['sub'];
?>
                                                <?php if ($_smarty_tpl->tpl_vars['sub']->value['id'] == 'separador') {?>
                                                    <li role="separator" class="divider"></li>
                                                    <?php } else { ?>
                                                    <li ><a href="<?php echo $_smarty_tpl->tpl_vars['sub']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['sub']->value['titulo'];?>
</a></li>
                                                    <?php }?>
                                                <?php
$_smarty_tpl->tpl_vars['sub'] = $foreach_sub_Sav;
}
?>
                                        </ul>
                                    </li>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['item']) && $_smarty_tpl->tpl_vars['_layoutParams']->value['item'] == $_smarty_tpl->tpl_vars['menu']->value['id']) {?>
                                        <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('active', null, 0);?>
                                    <?php } else { ?>
                                        <?php $_smarty_tpl->tpl_vars['_clase'] = new Smarty_Variable('', null, 0);?>
                                    <?php }?>
                                    <li class="<?php echo $_smarty_tpl->tpl_vars['_clase']->value;?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['enlace'];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value['titulo'];?>
</a></li>
                                    <?php }?>
                                <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['menu'] = $foreach_menu_Sav;
}
?>
                        <?php }?>
                </ul>
            </div><!--/.nav-collapse -->
        </nav>
        <div class="container-fluid">
            <?php if (isset($_smarty_tpl->tpl_vars['titulo']->value)) {?>
                <div class="page-header">
                    <h1>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['titulo']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_name'] : $tmp);?>

                        <?php if (isset($_smarty_tpl->tpl_vars['cuenta']->value)) {?><span class="badge"><?php echo $_smarty_tpl->tpl_vars['cuenta']->value;?>
</span><?php }?>
                    </h1>
                </div>
            <?php }?>
            <div class="container">
                
                <noscript> 
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span><strong>Atención: </strong> JavaScript está deshabilitado. <a target="_blank" href="http://enable-javascript.com/es/" class="alert-link">Habilite Javascript para el buen funcionamiento de la aplicación</a>.</span>
                </div>
                </noscript> 
                <?php if (isset($_smarty_tpl->tpl_vars['error']->value)) {?>
                    <!--Mensajes generales-->
                    <div class="row">
                        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <h3>Atenci&oacute;n</h3> <hr>
                            <?php echo $_smarty_tpl->tpl_vars['error']->value;?>

                        </div>
                    </div>
                <?php }?>

                <?php if (isset($_smarty_tpl->tpl_vars['mensaje']->value)) {?>
                    <!--Mensajes generales-->
                    <div class="row">
                        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $_smarty_tpl->tpl_vars['mensaje']->value;?>

                        </div>
                    </div>
                <?php }?>

                

                
                <div id="template">
                    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['_contenido']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

                    <div id="version">
                        v: <span class="badge"><?php echo VERSION_MAJOR;?>
.<?php echo VERSION_MINOR;?>
.<?php echo VERSION_PATCH;?>
</span>
                    </div>
                </div>
            </div><!--cuerpo-->
        </div><!--container-->

        <?php if (((Session::esAdmin() || Session::getId() == 31))) {?>
            <footer class='hidden-xs footer col-md-12 text-center bg-success ' style='margin-top:15px;padding:5px;'>
                <strong>ROOT:</strong> <?php echo ROOT;?>
 | <strong>BASE_URL:</strong> <?php echo BASE_URL;?>
<br><?php echo info_sesion(' | ');?>

                <div class="">
                    <h4>
                        <?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_slogan'];?>
<br>
                        <small><?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_company'];?>
</small>
                    </h4>
                </div>
            </footer>
        <?php } else { ?>
            <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['_layoutParams']->value['footer'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

        <?php }?>
    </body>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
public/js/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
public/js/modernizr.custom.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_js'];?>
bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
public/js/jquery.validate.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
public/js/scripts.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['root'];?>
public/js/login.js"><?php echo '</script'; ?>
>
    <?php if (isset($_smarty_tpl->tpl_vars['_layoutParams']->value['js']) && count($_smarty_tpl->tpl_vars['_layoutParams']->value['js'])) {?>
        <?php
$_from = $_smarty_tpl->tpl_vars['_layoutParams']->value['js'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['js'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['js']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['js']->value) {
$_smarty_tpl->tpl_vars['js']->_loop = true;
$foreach_js_Sav = $_smarty_tpl->tpl_vars['js'];
?>
            <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
"><?php echo '</script'; ?>
>
        <?php
$_smarty_tpl->tpl_vars['js'] = $foreach_js_Sav;
}
?>
    <?php }?>
    
    <?php echo '<script'; ?>
>
        console.log($('footer').height());
    <?php echo '</script'; ?>
>

</html><?php }
}
?>