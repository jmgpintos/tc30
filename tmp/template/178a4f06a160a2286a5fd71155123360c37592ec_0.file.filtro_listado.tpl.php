<?php /* Smarty version 3.1.24, created on 2015-09-23 19:07:02
         compiled from "F:/xampp/htdocs/tc30/views/ficha_cursos/filtro_listado.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:187965602dc36023fc6_02245700%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '178a4f06a160a2286a5fd71155123360c37592ec' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/ficha_cursos/filtro_listado.tpl',
      1 => 1441024380,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '187965602dc36023fc6_02245700',
  'variables' => 
  array (
    'controlador' => 0,
    'pagina' => 0,
    'cursos' => 0,
    'curso' => 0,
    'filtro' => 0,
    'centros' => 0,
    'centro' => 0,
    'filtrado' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602dc3606a4f8_32918305',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602dc3606a4f8_32918305')) {
function content_5602dc3606a4f8_32918305 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '187965602dc36023fc6_02245700';
?>
<div class="col-md-12">
        <h2 class="text-primary">Filtrar listado</h2>
</div>
<hr/>

<form class="col-md-12" role="form" method="post" action="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/index/<?php echo $_smarty_tpl->tpl_vars['pagina']->value;?>
">
    <div class="form-group ">
        <label for="nombre" class="control-label">Curso</label>
        <div>
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                <select class="form-control" id="id_curso" name="id_curso" autofocus
                        onchange="this.form.submit()">
                    <?php
$_from = $_smarty_tpl->tpl_vars['cursos']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['curso'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['curso']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['curso']->value) {
$_smarty_tpl->tpl_vars['curso']->_loop = true;
$foreach_curso_Sav = $_smarty_tpl->tpl_vars['curso'];
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['curso']->value['id'];?>
"
                                <?php if ((isset($_smarty_tpl->tpl_vars['filtro']->value['id_curso']) && $_smarty_tpl->tpl_vars['curso']->value['id'] == $_smarty_tpl->tpl_vars['filtro']->value['id_curso'])) {?>
                                    selected="selected"
                                <?php }?>                                        
                                >
                            <?php echo $_smarty_tpl->tpl_vars['curso']->value['nombre'];?>

                        </option>
                    <?php
$_smarty_tpl->tpl_vars['curso'] = $foreach_curso_Sav;
}
?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group ">
        <label for="nombre" class="control-label">Centro</label>
        <div>
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-home"></span>
                <select class="form-control" id="id_centro" name="id_centro"
                        onchange="this.form.submit()">
                    <?php
$_from = $_smarty_tpl->tpl_vars['centros']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['centro'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['centro']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['centro']->value) {
$_smarty_tpl->tpl_vars['centro']->_loop = true;
$foreach_centro_Sav = $_smarty_tpl->tpl_vars['centro'];
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['centro']->value['id'];?>
"
                                <?php if ((isset($_smarty_tpl->tpl_vars['filtro']->value['id_centro']) && $_smarty_tpl->tpl_vars['centro']->value['id'] == $_smarty_tpl->tpl_vars['filtro']->value['id_centro'])) {?>
                                    selected="selected"
                                <?php }?>>
                            <?php echo $_smarty_tpl->tpl_vars['centro']->value['nombre'];?>

                        </option>
                    <?php
$_smarty_tpl->tpl_vars['centro'] = $foreach_centro_Sav;
}
?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group ">
        <label for="desde">Desde</label><br/>
        <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
            <input type="date" class="form-control" name="desde" id="desde" placeholder="aaaa-mm-dd" 
                   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['filtro']->value['desde'])===null||$tmp==='' ? '' : $tmp);?>
" onchange="this.form.submit()">
        </div>
    </div>

    <div class="form-group ">
        <label for="hasta">Hasta</label><br/>
        <div class="input-group">
            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
            <input type="date" class="form-control" name="hasta" id="hasta" placeholder="aaaa-mm-dd"
                   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['filtro']->value['hasta'])===null||$tmp==='' ? '' : $tmp);?>
" onchange="this.form.submit()">
        </div>
    </div>
    <button class="form-control btn
            <?php if (($_smarty_tpl->tpl_vars['filtrado']->value)) {?>}
                btn-danger
            <?php } else { ?>
                btn-primary disabled hidden
            <?php }?>
            " name="limpiar" value="limpiar">Limpiar filtro</button>
</form>
<?php }
}
?>