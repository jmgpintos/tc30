<?php /* Smarty version 3.1.24, created on 2015-09-24 14:52:04
         compiled from "C:/xampp/htdocs/tc30/views/estadisticas/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:179605603f1f4b4c0e9_04986334%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd68463fe516f33f2ba244279cf8ecd49ab6e8643' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/estadisticas/index.tpl',
      1 => 1443099122,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179605603f1f4b4c0e9_04986334',
  'variables' => 
  array (
    'datos' => 0,
    'metodos_sql1' => 0,
    'item' => 0,
    'seleccionados' => 0,
    'metodos_sql2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603f1f4bdc987_84086327',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603f1f4bdc987_84086327')) {
function content_5603f1f4bdc987_84086327 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '179605603f1f4b4c0e9_04986334';
?>
<?php echo '<script'; ?>
>
    console.log($('#footer').height());
<?php echo '</script'; ?>
>
    
    


<div class="row">

    <form class="" action="" method="post" >

        <input type="hidden" name="guardar" value="1">
        <div class="row">
            <div class="alert alert-info col-md-8 col-md-push-2">

                <div class="col-md-3 text-center">
                    <div class="form-group">
                        <label class="control-label" for="desde">Desde</label>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                                   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['desde'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>     
                    </div>
                </div>

                <div class="col-md-3 col-md-push-1 text-center">
                    <div class="form-group">
                        <label  class="control-label" for="hasta">Hasta</label>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd" 
                                   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hasta'])===null||$tmp==='' ? '' : $tmp);?>
" >
                        </div>                                
                    </div>                                
                </div>
                <br/>
                <div class="alert alert-info col-md-4 text-center form-group pull-right">

                    <input type="checkbox" name="outPDF" id="outPDF" autocomplete="off"
                           <?php if (isset($_smarty_tpl->tpl_vars['datos']->value['outPDF'])) {?>
                               checked=""
                           <?php }?>
                           />
                    <div class="btn-group">
                        <label for="outPDF" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok"></span>
                            <span> </span>
                        </label>
                        <label for="outPDF" class="btn btn-default active">
                            PDF
                        </label>
                    </div>
                        
                    <div class="btn-group">
                        <input type="checkbox" name="outXLS" id="outXLS" autocomplete="off"
                           <?php if (isset($_smarty_tpl->tpl_vars['datos']->value['outXLS'])) {?>
                               checked=""
                           <?php }?>
                           />
                        <div class="btn-group">
                            <label for="outXLS" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok"></span>
                                <span> </span>
                            </label>
                            <label for="outXLS" class="btn btn-default active">
                                XLS
                            </label>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default col-md-10 col-md-push-1">
                <div class="panel-heading">
                    <h3 class="text-primary">Seleccione estad&iacute;sticas para consultar</h3>
                </div>
                <div id="SQLs" class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php
$_from = $_smarty_tpl->tpl_vars['metodos_sql1']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                                <div >
                                    <input type="checkbox" id ="SQL<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" name="checkbox[]"
                                           <?php if ((isset($_smarty_tpl->tpl_vars['seleccionados']->value))) {?>
                                               <?php if (in_array($_smarty_tpl->tpl_vars['item']->value['id'],$_smarty_tpl->tpl_vars['seleccionados']->value)) {?>checked=""<?php }?>
                                           <?php }?>
                                           >
                                    <label for="SQL<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>

                                    </label>
                                </div>
                            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>

                        </div>
                        <div class="col-md-6">
                            <?php
$_from = $_smarty_tpl->tpl_vars['metodos_sql2']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                                <div >
                                    <input type="checkbox" id ="SQL<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" name="checkbox[]"
                                           <?php if ((isset($_smarty_tpl->tpl_vars['seleccionados']->value))) {?>
                                               <?php if (in_array($_smarty_tpl->tpl_vars['item']->value['id'],$_smarty_tpl->tpl_vars['seleccionados']->value)) {?>checked=""<?php }?>
                                           <?php }?>
                                           >
                                    <label for="SQL<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                                        <?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>

                                    </label>
                                </div>
                            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12 text-center">

                            <a class="btn btn-info btn-sm" id="btnseleccionarTodos" onclick="seleccionarTodos()">seleccionar Todos</a>
                            <a class="btn btn-info btn-sm" id="btnseleccionarNinguno" onclick="seleccionarNinguno()">seleccionar Ninguno</a>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>
            <input class="form-control btn btn-primary" type="submit" value="Enviar">
            </form>
        </div><?php }
}
?>