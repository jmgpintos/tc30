<?php /* Smarty version 3.1.24, created on 2015-09-23 14:23:41
         compiled from "C:/xampp/htdocs/tc30/views/dinamizador/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:28290560299cd779048_04987632%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17191d2285a041d9ee7b3c23852c4c03df499595' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/dinamizador/index.tpl',
      1 => 1441693362,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28290560299cd779048_04987632',
  'variables' => 
  array (
    '_error' => 0,
    '_mensaje' => 0,
    'posts' => 0,
    'controlador' => 0,
    'post' => 0,
    'role' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_560299cd8f0092_48315153',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_560299cd8f0092_48315153')) {
function content_560299cd8f0092_48315153 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '28290560299cd779048_04987632';
?>

<?php if (isset($_smarty_tpl->tpl_vars['_error']->value)) {?>
    <!--Mensajes privados de cada controlador-->
    <div class="row">
        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <h3>Atenci&oacute;n</h3> <hr> 
            <?php echo $_smarty_tpl->tpl_vars['_error']->value;?>

        </div>
    </div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['_mensaje']->value)) {?>
    <!--Mensajes privados de cada controlador-->
    <div class="row">
        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            <div class="text-center">
                <?php echo $_smarty_tpl->tpl_vars['_mensaje']->value;?>

            </div>
        </div>
    </div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['posts']->value) && count($_smarty_tpl->tpl_vars['posts']->value)) {?>
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr>
                <th></th>

                <th>Nombre</th>
                <th>e-mail</th>
                <th>Tel&eacute;fono</th>
                <th>Centro</th>
                    <?php if (Session::accesoView('especial')) {?>
                    <th>&Uacute;ltimo acceso</th>
                    <?php }?>
                <th class="text-center">
                    <?php if (Session::accesoView('especial')) {?>
                        <a class="btn btn-primary btn-round" title="Crear nuevo" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                        <?php }?>
                </th>
            </tr>
        </thead>
        <?php
$_from = $_smarty_tpl->tpl_vars['posts']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['post'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['post']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
$_smarty_tpl->tpl_vars['post']->_loop = true;
$foreach_post_Sav = $_smarty_tpl->tpl_vars['post'];
?>

            <tr 
                <?php if (($_smarty_tpl->tpl_vars['post']->value['estado'] == "0")) {?>
                    class="text-muted" style='font-style: italic'
                <?php }?>
                >
                <td style="text-align: center;">
                    <?php if (($_smarty_tpl->tpl_vars['post']->value['role'] == 'usuario')) {?> 
                        <?php $_smarty_tpl->tpl_vars["role"] = new Smarty_Variable("<span title='usuario' class='text-primary'>", null, 0);?>
                    <?php } elseif (($_smarty_tpl->tpl_vars['post']->value['role'] == 'admin')) {?> 
                        <?php $_smarty_tpl->tpl_vars["role"] = new Smarty_Variable("<span title='admin' class='text-danger'>", null, 0);?>
                    <?php } elseif (($_smarty_tpl->tpl_vars['post']->value['role'] == 'especial')) {?> 
                        <?php $_smarty_tpl->tpl_vars["role"] = new Smarty_Variable("<span title='especial' class='text-success'>", null, 0);?>
                    <?php } else { ?> 
                        <?php $_smarty_tpl->tpl_vars["role"] = new Smarty_Variable("<span title='error' class='text-info'>", null, 0);?>
                    <?php }?>
                    <?php echo $_smarty_tpl->tpl_vars['role']->value;?>
<i class="glyphicon glyphicon-user"></i></span>
                </td>
                <td><?php echo $_smarty_tpl->tpl_vars['post']->value['nombre'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['post']->value['email'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['post']->value['telefono'];?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['post']->value['centro'])===null||$tmp==='' ? '<em class="text-info">Sin centro asignado</em>' : $tmp);?>
</td>
                    <?php if (Session::accesoView('especial')) {?>
                    <td><?php echo $_smarty_tpl->tpl_vars['post']->value['ultimo_acceso'];?>
</td>
                    <?php }?>
                <td class="text-center">
                    <?php if (Session::accesoViewEstricto(array('especial'))) {?>
                        <a class="btn btn-default btn-round" title="Editar datos de dinamizador" href="<?php echo BASE_URL;?>
dinamizador/editar/<?php echo $_smarty_tpl->tpl_vars['post']->value['id'];?>
"><span class=" glyphicon glyphicon-pencil"></span></a>
                        <?php }?>
                        <?php if (Session::accesoViewEstricto(array('especial'))) {?>
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="<?php echo BASE_URL;?>
dinamizador/eliminar/<?php echo $_smarty_tpl->tpl_vars['post']->value['id'];?>
" 
                            data-alumno="<?php echo $_smarty_tpl->tpl_vars['post']->value['nombre'];?>
"
                            title="Borrar dinamizador">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                    <?php }?>
                </td>
            </tr>
        <?php
$_smarty_tpl->tpl_vars['post'] = $foreach_post_Sav;
}
?>
    </table>
    <hr>
<?php } else { ?>
    <div class="alert alert-warning">
        No hay datos!!
    </div>
<?php }?>
<?php echo $_smarty_tpl->tpl_vars['paginacion']->value;?>


<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el registro correspondiente a <strong><span id="nombre-alumno" class="text-primary"></span></strong> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

<?php }
}
?>