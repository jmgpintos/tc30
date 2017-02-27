<?php /* Smarty version 3.1.24, created on 2015-09-23 17:26:51
         compiled from "F:/xampp/htdocs/tc30/views/log/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:206175602c4bb1920c1_84701362%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcae0d069c15f00179a06311b2841dee500905a3' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/log/index.tpl',
      1 => 1441994926,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '206175602c4bb1920c1_84701362',
  'variables' => 
  array (
    'datos' => 0,
    'dato' => 0,
    'controlador' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602c4bb1efcf2_20609867',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602c4bb1efcf2_20609867')) {
function content_5602c4bb1efcf2_20609867 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '206175602c4bb1920c1_84701362';
?>

<div class="col-md-12 pull-right">
     
    
    <?php if (isset($_smarty_tpl->tpl_vars['datos']->value) && count($_smarty_tpl->tpl_vars['datos']->value)) {?>
        <table class="table table-striped table-hover ">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Nivel</th>
                    <th>Usuario</th>
                    <th>ip</th>
                    <th>Hora</th>
                    <th>M&eacute;todo</th>
                    <th>Mensaje</th>
                    <th>Tabla</th>
                    <th></th>
                </tr>
            </thead>
            <?php
$_from = $_smarty_tpl->tpl_vars['datos']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['dato'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['dato']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['dato']->value) {
$_smarty_tpl->tpl_vars['dato']->_loop = true;
$foreach_dato_Sav = $_smarty_tpl->tpl_vars['dato'];
?>
                <tr>
                    <td class="text-info small"><?php echo $_smarty_tpl->tpl_vars['dato']->value['row'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['nivel'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['usuario'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['ip'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['tiempo'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['metodo'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['mensaje'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['tabla'];?>
</td>
                    <td class="text-center">
                        <a title="Ver curso" class="btn btn-primary btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver/<?php echo $_smarty_tpl->tpl_vars['dato']->value['id'];?>
">
                            <span class=" glyphicon glyphicon-eye-open"></span>
                        </a>
                    </td>
                </tr>
            <?php
$_smarty_tpl->tpl_vars['dato'] = $foreach_dato_Sav;
}
?>
        </table>
        <hr>
        <?php echo $_smarty_tpl->tpl_vars['paginacion']->value;?>

    <?php } else { ?>
        <div class="alert alert-warning">
            No hay cursos que cumplan con las condiciones
        </div>
    <?php }?>
</div>


<?php }
}
?>