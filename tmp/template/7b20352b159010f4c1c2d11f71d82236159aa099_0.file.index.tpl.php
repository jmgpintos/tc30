<?php /* Smarty version 3.1.24, created on 2015-09-23 14:27:35
         compiled from "C:/xampp/htdocs/tc30/views/incidencias/index.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:208556029ab7426e84_52321003%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b20352b159010f4c1c2d11f71d82236159aa099' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/incidencias/index.tpl',
      1 => 1441625082,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '208556029ab7426e84_52321003',
  'variables' => 
  array (
    'controlador' => 0,
    'es_busqueda' => 0,
    'datos' => 0,
    'item' => 0,
    'paginacion' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56029ab74bb5a4_64971212',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56029ab74bb5a4_64971212')) {
function content_56029ab74bb5a4_64971212 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '208556029ab7426e84_52321003';
?>


    <?php if (isset($_smarty_tpl->tpl_vars['controlador']->value)) {?>
        <div class="visible-xs pull-right text-right">
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
    
    <table class="table table-striped table-hover table-condensed">
        <thead class="bg-primary">
            <tr >
                <th></th>
                <th>Centro</th>
                <th>Equipo</th>
                <th>Tipo</th>
                <th>T&eacute;cnico</th>
                <th>Fecha de creación</th>
                <th class="text-center">Estado  </th>
                <th class="text-center">
                    <a class="btn btn-primary btn-round" 
                       title="Crear nuevo" 
                       href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/nuevo">
                        <i class="glyphicon glyphicon-plus"></i>
                    </a>
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
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['centro'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['equipo'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['txt_tipo'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['tecnico'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['fecha_creacion'];?>
</td>
                <td class="text-center">
                    <?php if (($_smarty_tpl->tpl_vars['item']->value['estado'] == 1)) {?>
                        <i class="text-success fa fa-2x fa-check-circle" title="cerrada"></i>
                    <?php } else { ?>
                        <i class="text-danger fa fa-2x fa-times-circle" title="abierta"></i>
                    <?php }?>
                </td>
                <td class="text-center">
                    <a href="index.phtml"></a>
                    
                    <a class="btn btn-primary btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Ver ficha de la incidencia"><span class=" glyphicon glyphicon-eye-open"></span></a>
                        
                        
                    <a class="btn btn-default btn-round" href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/editar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Editar ficha de la incidencia"><span class=" glyphicon glyphicon-pencil"></span></a>
                        
                        <?php if (Session::accesoViewEstricto(array('especial'))) {?>
                        <a 
                            class="btn btn-danger btn-round"
                            href="#" 
                            data-toggle="modal" 
                            data-target="#confirmar-borrar" 
                            data-href="<?php echo BASE_URL;
echo $_smarty_tpl->tpl_vars['controlador']->value;?>
/eliminar/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" 
                            data-centro="<?php echo $_smarty_tpl->tpl_vars['item']->value['id_centro'];?>
"
                            data-equipo="<?php echo $_smarty_tpl->tpl_vars['item']->value['id_equipo'];?>
"
                            data-tipo="<?php echo $_smarty_tpl->tpl_vars['item']->value['tipo'];?>
"
                            data-fecha="<?php echo $_smarty_tpl->tpl_vars['item']->value['fecha_creacion'];?>
"
                            title="Borrar incidencia">
                            <i class=" glyphicon glyphicon-trash"></i>
                        </a>
                        
                    <?php }?>
                </td>
            </tr>
        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
    </table>
    <?php echo $_smarty_tpl->tpl_vars['paginacion']->value;?>


    
    






<div class="modal fade" id="confirmar-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Borrar dinamizador</h4>
            </div>
            <div class="modal-body">
                ¿Desea borrar este registro?<br/>
                <div class="row col-md-10 col-md-push-2">
                    Centro: <span id="centro-incidencia" class="text-primary"></span><br/>
                    Equipo: <span id="equipo-incidencia" class="text-primary"></span><br/>
                    Tipo de incidencia: <span id="tipo-incidencia" class="text-primary"></span><br/>
                    Fecha: <span id="fecha-incidencia" class="text-primary"></span>
                </div>
                <div class="row"></div>

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