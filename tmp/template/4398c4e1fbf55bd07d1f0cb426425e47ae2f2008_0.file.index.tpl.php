<?php /* Smarty version 3.1.24, created on 2015-09-24 11:47:20
         compiled from "C:/xampp/htdocs/tc30/views/aula_responsables/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:194005603c6a832a072_81462226%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4398c4e1fbf55bd07d1f0cb426425e47ae2f2008' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_responsables/index.tpl',
      1 => 1443088038,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '194005603c6a832a072_81462226',
  'variables' => 
  array (
    'datos' => 0,
    'controlador' => 0,
    'es_busqueda' => 0,
    'item' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603c6a838bb04_64328615',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603c6a838bb04_64328615')) {
function content_5603c6a838bb04_64328615 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '194005603c6a832a072_81462226';
if (isset($_smarty_tpl->tpl_vars['datos']->value) && count($_smarty_tpl->tpl_vars['datos']->value)) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['controlador']->value)) {?>
        <div class="visible-xs pull-right text-right">
            
        </div>
    <?php }?>
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr >
                <th></th>
                <th>NIF/NIE</th>
                <th>Nombre</th>
                <th class="hidden-xs">Tel&eacute;fono</th>
                <th class="hidden-xs">e-mail</th>
                <th class="text-center">
                    <?php if (isset($_smarty_tpl->tpl_vars['controlador']->value)) {?>
            <div class="hidden-xs pull-right text-right">
                <form class="navbar-form" role="form" method='post' action='<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/buscar'>
                    <div class="input-group" title="Buscar por telefono, DNI, nombre o apellidos">
                        <input type="text" class="form-control" placeholder="Buscar" name="busqueda">
                        <div class="input-group-btn">
                            <button class="btn btn-default btn-suave" type="submit" ><i class="glyphicon glyphicon-search"></i></button>
                                <?php if ($_smarty_tpl->tpl_vars['es_busqueda']->value) {?>
                                <a href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver_todo" class="btn btn-danger" type="submit" title="Ver todo"><i class="glyphicon glyphicon-eye-open"></i></a>
                                <?php }?>
                        </div>
                    </div>
                </form>
            </div>
        <?php }?>
    </th>
</tr>
</thead>
<?php
$_from = $_smarty_tpl->tpl_vars['datos']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
    <tr>
        <td class="text-info small"><?php echo $_smarty_tpl->tpl_vars['item']->value['row'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['item']->value['dni'];?>
</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['item']->value['sexo'] == 'H') {?>
                <i class='fa fa-male fa-fw' title="Hombre"></i>
            <?php } else { ?>
                <i class="fa fa-female fa-fw" title="Mujer"></i>
            <?php }?>
            <?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>

        </td>
        <td class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['item']->value['telefono'];?>
</td>
        <td class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['item']->value['email'];?>
</td>
        <td class="text-center">
            <a href="index.phtml"></a>
            
            <a class="btn btn-primary btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Ver ficha del alumno"><span class=" glyphicon glyphicon-eye-open"></span></a>
                
                
            <a class="btn btn-default btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/editar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Editar datos del alumno"><span class=" glyphicon glyphicon-pencil"></span></a>
                
                <a 
                    class="btn btn-danger btn-round"
                    href="#" 
                    data-toggle="modal" 
                    data-target="#confirmar-borrar" 
                    data-href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/eliminar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" 
                    data-alumno="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
"
                    title="Borrar registro">
                    <i class=" glyphicon glyphicon-trash"></i>
                </a>
                
        </td>
    </tr>
<?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
</table>
<?php echo $_smarty_tpl->tpl_vars['paginacion']->value;?>

<?php } else { ?>
    
    <div class="col-md-4 col-md-push-4 alert alert-warning text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay resultados<hr/>
        <a href ="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/index" class="btn btn-warning form-control" >Volver</a>
    </div>
<?php }?>





<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el registro correspondiente a <span id="nombre-alumno" class="text-primary"></span> ?
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