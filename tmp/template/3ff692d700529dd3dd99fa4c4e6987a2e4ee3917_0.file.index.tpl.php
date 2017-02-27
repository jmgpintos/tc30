<?php /* Smarty version 3.1.24, created on 2015-09-24 11:45:30
         compiled from "C:/xampp/htdocs/tc30/views/aula_actividades/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:93235603c63ad7d927_45334313%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ff692d700529dd3dd99fa4c4e6987a2e4ee3917' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_actividades/index.tpl',
      1 => 1443087929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '93235603c63ad7d927_45334313',
  'variables' => 
  array (
    'actividades' => 0,
    'controlador' => 0,
    'item' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603c63adfe7c2_71895358',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603c63adfe7c2_71895358')) {
function content_5603c63adfe7c2_71895358 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '93235603c63ad7d927_45334313';
?>

<?php if (isset($_smarty_tpl->tpl_vars['actividades']->value) && count($_smarty_tpl->tpl_vars['actividades']->value)) {?>
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr >
                <th></th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Responsable</th>
                <th class="hidden-xs">Fechas</th>
                <th class="hidden-xs">Horario</th>
                <th class="text-center">
                    <a class="btn btn-warning btn-sm" title="Crear nuevo" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/nuevo"><i class="glyphicon glyphicon-plus"></i>&nbsp; Nueva actividad</a>
                </th>
            </tr>
        </thead>
        <?php
$_from = $_smarty_tpl->tpl_vars['actividades']->value;
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
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['tipo_actividad'];?>
</td>
                <td 
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['nombre_elipsis'] != $_smarty_tpl->tpl_vars['item']->value['nombre']) {?>
                        title="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
"
                    <?php }?>
                    >
                    <?php echo $_smarty_tpl->tpl_vars['item']->value['nombre_elipsis'];?>

                </td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['responsable'];?>
</td>
                <td class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['item']->value['fechas'];?>
</td>
                <td class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['item']->value['horas'];?>
</td>
                <td class="text-center">
                    <a class="btn btn-info btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Ver ficha"><i class="glyphicon glyphicon-eye-open"></i></a>
                        <?php if (Session::accesoViewEstricto(array('aula_innova','especial'))) {?>
                        <a title="Editar actividad" class="btn btn-default btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/editar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                            <span class=" glyphicon glyphicon-pencil"></span>
                        </a>
                    <?php }?>
                    <?php if (Session::accesoViewEstricto(array('aula_innova','especial'))) {?>
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/eliminar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" 
                            data-curso="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
"
                            title="Borrar actividad">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                    <?php }?>
                    <a title="Inscribir usuarios" class="btn btn-suave btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/inscribir/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                        <span class=" glyphicon glyphicon-list"></span>
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
    <div class="alert alert-info text-center">
        <strong>ATENCI&Oacute;N</strong> - No hay datos que mostrar
    </div>
<?php }?>
<hr/>




<!--modal confirmar borrar curso-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar el curso <span id="curso" class="text-primary"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div><?php }
}
?>