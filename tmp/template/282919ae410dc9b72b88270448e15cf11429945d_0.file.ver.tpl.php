<?php /* Smarty version 3.1.24, created on 2015-09-24 13:43:08
         compiled from "C:/xampp/htdocs/tc30/views/ficha_cursos/ver.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:236685603e1cc85fb54_97759630%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '282919ae410dc9b72b88270448e15cf11429945d' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/ficha_cursos/ver.tpl',
      1 => 1443094987,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '236685603e1cc85fb54_97759630',
  'variables' => 
  array (
    'datos' => 0,
    'profesor' => 0,
    'pagina_listado' => 0,
    '_error' => 0,
    '_mensaje' => 0,
    'alumnos' => 0,
    'matriculados' => 0,
    'controlador' => 0,
    'plazas_libres' => 0,
    'item' => 0,
    'titulo' => 0,
    'paginas' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603e1cc923089_37880895',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603e1cc923089_37880895')) {
function content_5603e1cc923089_37880895 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '236685603e1cc85fb54_97759630';
?>
<div class="well well-sm col-xs-12 col-md-3">
    <div class="alert bg-info col-md-12 info-curso">
        <div class="pull-right ">
            <a href="<?php echo BASE_URL;?>
ficha_cursos/editar/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
" class="btn btn-default btn-round" title="Editar">
                <span class=" glyphicon glyphicon-pencil"></span>
            </a>
            <?php if (Session::accesoView('especial')) {?>
                <a class="btn btn-danger btn-round" href="<?php echo BASE_URL;?>
ficha_cursos/eliminar/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
" title="Borrar alumno">
                    <span class=" glyphicon glyphicon-trash"></span>
                </a>
            <?php }?>
        </div>

        <h3 class="col-md-7"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['curso'])===null||$tmp==='' ? '' : $tmp);?>
</h3>

        <div class="col-md-12 text-right "><strong><?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['centro'])===null||$tmp==='' ? '' : $tmp);?>
</strong> <small>(<?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['aforo'])===null||$tmp==='' ? '' : $tmp);?>
)</small></div>

        <div class="col-md-12 text-right "><small><?php echo (($tmp = @$_smarty_tpl->tpl_vars['profesor']->value)===null||$tmp==='' ? '' : $tmp);?>
</small></div>

    </div>

    <div class="panel-group">
        <div class="panel panel-success">
            <div class="panel-heading text-center"><label>Fechas</label></div>
            <div class="panel-body text-info text-center">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading text-center"><label>Horario</label></div>
            <div class="panel-body text-info text-center" >De <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora'])===null||$tmp==='' ? '' : $tmp);?>
 a <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['hora_fin'])===null||$tmp==='' ? '' : $tmp);?>
</div>
        </div>
    </div>

    <div class=" col-md-12">

        <a href="<?php echo BASE_URL;?>
ficha_cursos/index/<?php echo $_smarty_tpl->tpl_vars['pagina_listado']->value;?>
" class="col-md-8 pull-right text-right btn btn-primary">
            <i class="glyphicon glyphicon-chevron-left"></i>
            Volver al listado</a>
            
    </div>
</div>


<div class="col-xs-12 col-md-8 ">

    <?php if (isset($_smarty_tpl->tpl_vars['_error']->value)) {?>
        <!--Mensajes privados de cada controlador-->
        <div class="row">
            <div class="alert alert-danger fade in">
                <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                <h3>Atenci&oacute;n</h3> <hr> 
                <?php echo $_smarty_tpl->tpl_vars['_error']->value;?>

            </div>
        </div>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['_mensaje']->value)) {?>
        <!--Mensajes privados de cada controlador-->
        <div class="row">
            <div class="alert alert-success fade in">
                <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                <div class="text-center">
                    <?php echo $_smarty_tpl->tpl_vars['_mensaje']->value;?>

                </div>
            </div>
        </div>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['alumnos']->value) && count($_smarty_tpl->tpl_vars['alumnos']->value)) {?>
    <div class="alert alert-info"><h2 class="text-center">Alumnos</h2></div>
        <table class="table table-striped table-hover table-condensed">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>DNI</th>
                    <th class="hidden-xs">Nombre</th>
                    <th>Telefono</th>
                        
                    <th></th>
                    <th class="text-center">
                        <?php if (($_smarty_tpl->tpl_vars['datos']->value['aforo'] > $_smarty_tpl->tpl_vars['matriculados']->value)) {?>
                            <a class="btn btn-primary btn-round" title="Matricular alumno" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/matricular/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
"><i class="glyphicon glyphicon-plus"></i></a><?php echo $_smarty_tpl->tpl_vars['plazas_libres']->value;?>

                                
                            <?php }?>
                    </th>
                </tr>
            </thead>
            
            <?php
$_from = $_smarty_tpl->tpl_vars['alumnos']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                <tr class='<?php if ($_smarty_tpl->tpl_vars['item']->value['matricula_completa']) {?>text-primary<?php } else { ?>text-danger<?php }?>'>
                    <td class="text-info small">
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['row'];?>

                        <?php if (($_smarty_tpl->tpl_vars['item']->value['discapacidad'])) {?>
                            <i class="fa fa-wheelchair fa-fw"  title="Discapacitado"></i>
                            
                        <?php }?>
                    </td>
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['dni'];?>
</td>
                    <td class="hidden-xs">
                        <?php if (($_smarty_tpl->tpl_vars['item']->value['sexo'] == 'H')) {?>
                            <i class='fa fa-male fa-fw' title="Hombre"></i>
                        <?php } else { ?>
                            <i class='fa fa-female fa-fw' title="Mujer"></i>
                        <?php }?>
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>

                    </td>
                    <td><?php echo ($_smarty_tpl->tpl_vars['item']->value['telefono']);?>
</td>
                    <td class="text-center">
                        
                        <a 
                            class="btn btn-default btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#modal-certificado" 
                            data-href="<?php echo BASE_URL;?>
ficha_cursos/certificado/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_alumno'];?>
" 
                            data-curso="<?php echo $_smarty_tpl->tpl_vars['datos']->value['curso'];?>
"
                            data-alumno="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
"
                            title="Obtener certificado">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-round" href="<?php echo BASE_URL;?>
alumno/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_alumno'];?>
" title="Ver ficha del alumno">
                            <i class=" glyphicon glyphicon-eye-open"></i>
                        </a>
                                                

                        <a class="btn btn-default btn-round" href="<?php echo BASE_URL;?>
ficha_cursos/matricularAlumno/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_curso'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_alumno'];?>
/ver" title="Editar datos de matr&iacute;cula">
                            <i class=" glyphicon glyphicon-pencil"></i>
                        </a>


                        

                        

                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="<?php echo BASE_URL;?>
ficha_cursos/borrarMatricula/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_alumno'];?>
" 
                            data-curso="<?php echo $_smarty_tpl->tpl_vars['datos']->value['curso'];?>
"
                            data-alumno="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre'];?>
"
                            title="Borrar <?php echo $_smarty_tpl->tpl_vars['titulo']->value;?>
">
                            <i class=" glyphicon glyphicon-remove-circle"></i>
                        </a>
                    </td>
                </tr>
            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
        </table>
        <?php if (($_smarty_tpl->tpl_vars['paginas']->value == 1)) {?>
            <?php echo $_smarty_tpl->tpl_vars['paginacion']->value;?>

        <?php }?>
    <?php } else { ?>
        <div class="alert alert-warning">
            No hay alumnos<hr/>
            <a class="btn btn-primary" title="Matricular alumno" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/matricular/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
"><i class="glyphicon glyphicon-plus"></i>Matricular</a>
        </div>
    <?php }?>

</div>

<!--modal confirmar borrado matrícula-->
<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar matr&iacute;cula del alumno</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-push-2">
                    ¿Desea borrar la matr&iacute;cula de <span id="nombre-alumno" class="text-primary"></span> 
                    del curso <span id="curso" class="text-primary"></span>?
                </div>
                <div class="row"></div>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok">Borrar</a>
            </div>
        </div>
    </div>
</div>

<!--modal certificado-->
<div class="modal fade" id="modal-certificado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Obtener certificado</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-8 col-md-push-2">
                    Obtener certificado de <span id="cert-nombre-alumno" class="text-primary"></span> <br/>
                    para el curso <span id="cert-curso" class="text-primary"></span>
                </div>
                <div class="row"></div>
                <hr/>

                <form id="form-fecha" role="form" class="form-horizontal" action="" method="post" name="fecha">     
                    <div class="row col-md-12">
                        <div class="form-group ">
                            <label for="fecha_certificado" class="control-label col-md-4">Fecha</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-calendar"></span>
                                    <input class="form-control" type="date" id="fecha-certificado" name="fecha_certificado"  placeholder="aaaa-mm-dd" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="margen" class="control-label col-md-4">Margen</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon glyphicon glyphicon-resize-horizontal"></span>
                                    <input class="form-control" type="number" id="margen" name="margen" value="25">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input class="btn btn-success" type="submit" value="Aceptar" form="form-fecha" id="submit">
            </div>
        </div>
    </div>
</div>
<?php }
}
?>