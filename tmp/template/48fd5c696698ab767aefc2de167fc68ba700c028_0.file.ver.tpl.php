<?php /* Smarty version 3.1.24, created on 2015-09-24 13:44:08
         compiled from "C:/xampp/htdocs/tc30/views/alumno/ver.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:320555603e2080cbe13_81612374%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48fd5c696698ab767aefc2de167fc68ba700c028' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/alumno/ver.tpl',
      1 => 1443095046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '320555603e2080cbe13_81612374',
  'variables' => 
  array (
    'ref' => 0,
    'datos' => 0,
    'cursos' => 0,
    'item' => 0,
    'paginas' => 0,
    'paginacion' => 0,
    'hoy' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603e208144fa6_39769257',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603e208144fa6_39769257')) {
function content_5603e208144fa6_39769257 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '320555603e2080cbe13_81612374';
?>
<div class="well well-sm col-xs-12 col-md-3">
    <div class="alert bg-info info-alumno col-md-12">
        <div class=" col-md-12">
            <a href="<?php echo $_smarty_tpl->tpl_vars['ref']->value;?>
" class="btn btn-sm btn-success" title="Volver">
                <i class="glyphicon glyphicon-chevron-left"></i>
            </a>
            
            
            <div class="pull-right">
                <a href="<?php echo BASE_URL;?>
alumno/editar/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
" class="btn btn-default btn-round" title="Editar">
                    <span class=" glyphicon glyphicon-pencil"></span>
                </a>
                <?php if (Session::accesoView('especial')) {?>
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="<?php echo BASE_URL;?>
alumno/eliminar/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
" 
                            data-alumno="<?php echo $_smarty_tpl->tpl_vars['datos']->value['nombre'];?>
"
                            title="Borrar alumno">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                <?php }?>
            </div>
        </div>
            
        <h3 class="col-md-2">
            <?php if ($_smarty_tpl->tpl_vars['datos']->value['sexo'] == 'H') {?>
                <i class="fa fa-2x fa-male" title="Hombre"></i>
            <?php } else { ?>
                <i class="fa fa-2x fa-female" title="Mujer"></i>
            <?php }?>
        </h3>
        <h3 class="col-md-7"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['nombre'])===null||$tmp==='' ? '' : $tmp);?>
</h3>

        <div class="col-md-12 text-right ">
            <strong><?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['dni'])===null||$tmp==='' ? '' : $tmp);?>
</strong>
        </div>
    </div>
    
    <div class="panel-group text-center" >

        <?php if ($_smarty_tpl->tpl_vars['datos']->value['discapacidad'] == TRUE) {?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <label >Persona con discapacidad</label>
                </div>
            </div>
        <?php }?>            

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Alumno desde</label>
            </div>
            <div class="panel-body text-info">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fecha_alta'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Teléfono</label>
            </div>
            <div class="panel-body text-info">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['telefono'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <label>Fecha de Nacimiento</label>
            </div>
            <div class="panel-body text-info">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['fechaNac'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
        </div>

    </div><!--panel-group-->

</div>



<div class="col-xs-12 col-md-7 col-md-push-1">
    

    <?php if (isset($_smarty_tpl->tpl_vars['cursos']->value) && count($_smarty_tpl->tpl_vars['cursos']->value)) {?>
    <div class="alert alert-info"><h2 class="text-center">Cursos</h2></div>
        <table class="table table-striped table-hover table-condensed">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th class="hidden-xs">Hora</th>
                    <th>Curso</th>
                    <th class="hidden-xs">Telecentro</th>
                    <th class="hidden-xs">Certificado</th>
                    <th class="text-center">
                    </th>
                </tr>
            </thead>
            <?php
$_from = $_smarty_tpl->tpl_vars['cursos']->value;
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
                    <td><?php echo $_smarty_tpl->tpl_vars['item']->value['fecha_inicio'];?>
</td>
                    <td class="hidden-xs"><?php echo $_smarty_tpl->tpl_vars['item']->value['hora_inicio'];?>
</td>
                    <td <?php if ($_smarty_tpl->tpl_vars['item']->value['nombre_curso'] != $_smarty_tpl->tpl_vars['item']->value['nombre_curso_elipsis']) {?>title="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre_curso'];?>
"<?php }?>>
                        <?php echo ($_smarty_tpl->tpl_vars['item']->value['nombre_curso_elipsis']);?>

                    </td>
                    <td  class="hidden-xs" <?php if ($_smarty_tpl->tpl_vars['item']->value['nombre_centro'] != $_smarty_tpl->tpl_vars['item']->value['nombre_centro_elipsis']) {?>title="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre_centro'];
}?>">
                        <?php echo ($_smarty_tpl->tpl_vars['item']->value['nombre_centro_elipsis']);?>

                    </td>
                    <td class="hidden-xs text-center">
                        <a 
                            class="btn btn-default btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#modal-certificado" 
                            data-href="<?php echo BASE_URL;?>
ficha_cursos/certificado/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_ficha_curso'];?>
/<?php echo $_smarty_tpl->tpl_vars['datos']->value['id'];?>
" 
                            data-curso="<?php echo $_smarty_tpl->tpl_vars['item']->value['nombre_curso'];?>
"
                            data-alumno="<?php echo $_smarty_tpl->tpl_vars['datos']->value['nombre'];?>
"
                            title="Obtener certificado">
                            <i class="fa fa-file-pdf-o"></i>
                        </a>
                        
                    </td>
                    <td class="text-center">
                        <a href="index.phtml"></a>
                        
                        <a class="btn btn-primary btn-round" href="<?php echo BASE_URL;?>
ficha_cursos/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id_ficha_curso'];?>
" title="Ver ficha del curso"><span class=" glyphicon glyphicon-eye-open"></span></a>
                            
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
            No hay cursos
        </div>
    <?php }?>
</div>
</div>

<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="titulo-modal"></h4>
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
                                    <input class="form-control" type="date" id="fecha_certificado" name="fecha_certificado" value="<?php echo $_smarty_tpl->tpl_vars['hoy']->value;?>
">
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