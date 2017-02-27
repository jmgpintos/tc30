<?php /* Smarty version 3.1.24, created on 2015-09-23 14:17:03
         compiled from "C:/xampp/htdocs/tc30/views/ficha_cursos/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:151865602983fa0a395_21801825%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ff1c16531111a3a5b06b1c4dcbc71d09215efea2' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/ficha_cursos/index.tpl',
      1 => 1441614172,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151865602983fa0a395_21801825',
  'variables' => 
  array (
    '_filtro' => 0,
    'datos' => 0,
    'controlador' => 0,
    'cuenta' => 0,
    'dato' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5602983fb890f2_79005926',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5602983fb890f2_79005926')) {
function content_5602983fb890f2_79005926 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '151865602983fa0a395_21801825';
?>
<div class="col-md-3 well well-lg">

    <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['_filtro']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

</div>

<div class="col-md-9 pull-right">

    <?php if (isset($_smarty_tpl->tpl_vars['datos']->value) && count($_smarty_tpl->tpl_vars['datos']->value)) {?>
        <table class="table table-striped table-hover ">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Curso</th>
                    <th>Centro</th>
                    <th class="text-center">
                        <?php if (Session::accesoView('especial')) {?>
                            <a class="btn btn-primary btn-round" title="Crear nuevo" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/nuevo"><i class="glyphicon glyphicon-plus"></i></a>
                                


                            <a 
                                class="btn btn-primary btn-round"
                                href="#" 
                                data-toggle="modal" 
                                data-target="#confirmar-imprimir-hojas-cursos" 
                                data-href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/HojaCurso" 
                                data-total="<?php echo $_smarty_tpl->tpl_vars['cuenta']->value;?>
"
                                title="Imprimir hojas cursos">
                                <i class=" glyphicon glyphicon-print"></i>
                            </a>
                        <?php }?>
                        
                    </th>
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
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['fecha'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['hora'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['curso'];?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['dato']->value['centro'];?>
</td>
                    <td class="text-center">
                        <a title="Ver curso" class="btn btn-primary btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver/<?php echo $_smarty_tpl->tpl_vars['dato']->value['id'];?>
">
                            <span class=" glyphicon glyphicon-eye-open"></span>
                        </a>
                        <?php if (Session::accesoViewEstricto(array('especial'))) {?>
                            <a title="Editar curso" class="btn btn-default btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/editar/<?php echo $_smarty_tpl->tpl_vars['dato']->value['id'];?>
">
                                <span class=" glyphicon glyphicon-pencil"></span>
                            </a>
                        <?php }?>
                        <?php if (Session::accesoViewEstricto(array('especial'))) {?>
                            <a 
                                class="btn btn-danger btn-round"
                                href="#" 
                                data-toggle="modal" 
                                data-target="#confirmar-borrar" 
                                data-href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/eliminar/<?php echo $_smarty_tpl->tpl_vars['dato']->value['id'];?>
" 
                                data-curso="<?php echo $_smarty_tpl->tpl_vars['dato']->value['curso'];?>
"
                                data-alumno=""
                                title="Borrar curso">
                                <i class=" glyphicon glyphicon-trash"></i>
                            </a>
                            
                            
                            
                        <?php }?>
                    </td>
                    <td>

                        <a title="Matricular alumnos" class="btn btn-suave btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/matricular/<?php echo $_smarty_tpl->tpl_vars['dato']->value['id'];?>
">
                            <span class=" glyphicon glyphicon-list"></span>
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
</div>
<?php }
}
?>