<?php /* Smarty version 3.1.24, created on 2015-09-24 08:15:02
         compiled from "C:/xampp/htdocs/tc30/views/estadisticas/index1.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1163560394e62c8bc1_37288812%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f59ba78c4a2d9258801ad7bf64fa76a9ae496ee8' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/estadisticas/index1.tpl',
      1 => 1443037506,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1163560394e62c8bc1_37288812',
  'variables' => 
  array (
    'metodos_sql' => 0,
    'sql' => 0,
    'item' => 0,
    'datos' => 0,
    'cols' => 0,
    'col' => 0,
    'dato' => 0,
    'key' => 0,
    'formato' => 0,
    'paginacion' => 0,
    'codigo_sql' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_560394e632e4d5_83904718',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_560394e632e4d5_83904718')) {
function content_560394e632e4d5_83904718 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1163560394e62c8bc1_37288812';
?>

<div class="row">
    <form class="alert alert-info col-md-3" action="<?php echo BASE_URL;?>
estadisticas/index1" method="post" >

        <div class="form-group ">
            <label class="control-label">Consulta: </label><br/>
            <div>
                <select class='form-control' name="sql" onchange="this.form.submit()">
                    <?php
$_from = $_smarty_tpl->tpl_vars['metodos_sql']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                        <?php if (($_smarty_tpl->tpl_vars['sql']->value == $_smarty_tpl->tpl_vars['item']->value['id'])) {?>
                            <option value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' selected><?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
</option>
                        <?php } else { ?>
                            <option value='<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
' ><?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
</option>
                        <?php }?>
                    <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class='row'>
                <div class="col-md-6">
                    <label class="control-label" for="desde">Desde</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                               value="">
                    </div>     
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class='row'>
                <div class="col-md-6">
                    <label  class="control-label" for="hasta">Hasta</label>
                    <div class="input-group">
                        <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                        <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd" 
                               value="" >
                    </div>                                
                </div>                                
            </div>
        </div>

    </form>


    <div class="col-md-8">

        <?php if (isset($_smarty_tpl->tpl_vars['datos']->value) && count($_smarty_tpl->tpl_vars['datos']->value)) {?>
            <table class="table table-striped table-hover ">
                <thead class="bg-primary">
                    <tr>
                        <?php
$_from = $_smarty_tpl->tpl_vars['cols']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['col'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['col']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['col']->value) {
$_smarty_tpl->tpl_vars['col']->_loop = true;
$foreach_col_Sav = $_smarty_tpl->tpl_vars['col'];
?>
                            <th class="text-center"><?php echo $_smarty_tpl->tpl_vars['col']->value;?>
</th>
                            <?php
$_smarty_tpl->tpl_vars['col'] = $foreach_col_Sav;
}
?>
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
                        <?php
$_from = $_smarty_tpl->tpl_vars['dato']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['accion']) && $_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['accion'] == 'round')) {?>
                                <td class="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['estilo'])===null||$tmp==='' ? '' : $tmp);?>
"><?php echo number_format($_smarty_tpl->tpl_vars['item']->value,2);?>
 <?php echo (($tmp = @$_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['simbolo'])===null||$tmp==='' ? '' : $tmp);?>
</td>
                            <?php } else { ?>
                                <td class="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['estilo'])===null||$tmp==='' ? '' : $tmp);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
 <?php echo (($tmp = @$_smarty_tpl->tpl_vars['formato']->value[$_smarty_tpl->tpl_vars['key']->value]['simbolo'])===null||$tmp==='' ? '' : $tmp);?>
</td>
                            <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
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
</div>

<div class="row">
    <div class="alert alert-info">
        <?php echo $_smarty_tpl->tpl_vars['codigo_sql']->value;?>

    </div>
</div>


<!--modal confirmar borrar curso-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar matr&iacute;cula del alumno</h4>
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
</div>

<!--modal confirmar imprimir hojas cursos-->
<div class="modal fade" id="confirmar-imprimir-hojas-cursos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo-modal"></h4>
            </div>
            <div class="modal-body">
                Va a crear un total de <span id="total" class="text-primary"></span> p&aacute;ginas,¿est&aacute; seguro? 
                <form id="form-imprimir" role="form" class="form-horizontal" action="" method="post" name="imprimir">     
                    <div class="col-md-10 col-md-push-2">
                        <input type="checkbox" id="alumnos" name="alumnos" value="alumnos" checked/> Incluir nombres de alumno
                        
                    </div>
                </form>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input class="btn btn-success" type="submit" value="Aceptar" form="form-imprimir" id="submit">
            </div>
        </div>
    </div>
</div><?php }
}
?>