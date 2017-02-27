<?php /* Smarty version 3.1.24, created on 2015-09-23 14:22:28
         compiled from "C:/xampp/htdocs/tc30/views/ficha_cursos/editar.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:549656029984c23b67_96165692%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32312d64d1d7e35d552e9e20f9d2196e7bc65ff0' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/ficha_cursos/editar.tpl',
      1 => 1440678976,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '549656029984c23b67_96165692',
  'variables' => 
  array (
    'cursos' => 0,
    'curso' => 0,
    'datos' => 0,
    'centros' => 0,
    'centro' => 0,
    'profesores' => 0,
    'profesor' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56029984d258a4_46891718',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56029984d258a4_46891718')) {
function content_56029984d258a4_46891718 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '549656029984c23b67_96165692';
?>
<div class="row">
    <div class="well well-sm col-md-6 col-md-push-3">

        <?php if (Session::accesoViewEstricto(array('admin'))) {?>
            <div class="alert alert-warning fade in" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Falta javascript</h2>
                <ul>
                    <li>Actualizar campos "fin" al cambiar valor de "inicio" (si "fin" está vacío)</li>
                    <li>Usar polyfill para campos fecha</li>
                </ul>
            </div>
        <?php }?>
        <a href="javascript:history.back(1)" class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="row col-md-12">  

                <div class="form-group ">
                    <label for="id_curso" class="control-label col-md-3">Curso</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-bookmark"></span>
                            <select class="form-control" id="id_curso" name="id_curso" autofocus>
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
                                            <?php if ((isset($_smarty_tpl->tpl_vars['datos']->value['id_curso']))) {?>
                                                <?php if (($_smarty_tpl->tpl_vars['datos']->value['id_curso'] == $_smarty_tpl->tpl_vars['curso']->value['id'])) {?>
                                                    selected="selected"
                                                <?php }?>
                                            <?php }?>><?php echo $_smarty_tpl->tpl_vars['curso']->value['nombre'];?>
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
                    <label for="id_centro" class="control-label col-md-3">Centro</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-home"></span>
                            <select class="form-control" id="id_centro" name="id_centro">
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
                                            <?php if ((isset($_smarty_tpl->tpl_vars['datos']->value['id_centro']))) {?>
                                                <?php if (($_smarty_tpl->tpl_vars['datos']->value['id_centro'] == $_smarty_tpl->tpl_vars['centro']->value['id'])) {?>
                                                    selected="selected"
                                                <?php }?>
                                            <?php }?>
                                            ><?php echo $_smarty_tpl->tpl_vars['centro']->value['nombre'];?>
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
                    <label for="id_profesor" class="control-label col-md-3">Profesor</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-user"></span>
                            <select class="form-control" id="id_profesor" name="id_profesor">
                                <?php
$_from = $_smarty_tpl->tpl_vars['profesores']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['profesor'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['profesor']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['profesor']->value) {
$_smarty_tpl->tpl_vars['profesor']->_loop = true;
$foreach_profesor_Sav = $_smarty_tpl->tpl_vars['profesor'];
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['profesor']->value['id'];?>
"
                                            <?php if ((isset($_smarty_tpl->tpl_vars['datos']->value['id_profesor']))) {?>
                                                <?php if (($_smarty_tpl->tpl_vars['datos']->value['id_profesor'] == $_smarty_tpl->tpl_vars['profesor']->value['id'])) {?>
                                                    selected="selected"
                                                <?php }?>
                                            <?php }?>
                                            ><?php echo $_smarty_tpl->tpl_vars['profesor']->value['nombre'];?>
</option>
                                <?php
$_smarty_tpl->tpl_vars['profesor'] = $foreach_profesor_Sav;
}
?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr/>

                <div class="form-group col-md-12">
                    <div class="form-group col-md-5 col-md-push-1">
                        <label for="fecha_inicio">Fecha inicio</label><br/>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_inicio'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>

                    <div class="form-group col-md-6 pull-right">
                        <label for="fecha_fin" >Fecha fin</label><br/>
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_fin'])===null||$tmp==='' ? '' : $tmp);?>
">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-md-push-1">
                    <div class="form-group col-md-3">
                        <div class="form-group">
                            <label for="hora_inicio">Hora inicio</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora_inicio'])===null||$tmp==='' ? '' : $tmp);?>
">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-3 col-md-push-2">
                        <div class="form-group text-center">
                            <label for="hora_fin">Hora fin</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="time" class="form-control" name="hora_fin" id="hora_fin" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora_fin'])===null||$tmp==='' ? '' : $tmp);?>
">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-3 pull-right">
                        <div class="form-group text-right">
                            <label for="horas_totales" >Horas totales</label><br/>
                            <div class="input-group">
                                <span class="input-group-addon glyphicon glyphicon-time"></span>
                                <input type="number" class="form-control" name="horas_totales" id="horas_totales" placeholder="" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['horas_totales'])===null||$tmp==='' ? '' : $tmp);?>
">
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            <div class="row"></div>
            <a href="<?php echo BASE_URL;?>
alumno/index/<?php echo Session::get('pagina');?>
" 
               class="visible-xs col-xs-12 btn btn-warning" title="Volver sin guardar">
                Volver</a>
               <hr/>
            <input type="submit" class="visible-xs col-xs-12 pull-right  btn btn-success" value="Guardar"/>
            <input type="submit" class="hidden-xs btn btn-success form-control" value="Guardar"/>


            </div>
        </form>

    </div>


    <?php }
}
?>