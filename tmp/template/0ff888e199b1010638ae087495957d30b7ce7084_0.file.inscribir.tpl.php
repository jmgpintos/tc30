<?php /* Smarty version 3.1.24, created on 2015-09-24 08:37:10
         compiled from "C:/xampp/htdocs/tc30/views/aula_actividades/inscribir.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:819056039a1623b3f1_18764981%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ff888e199b1010638ae087495957d30b7ce7084' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/aula_actividades/inscribir.tpl',
      1 => 1442832072,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '819056039a1623b3f1_18764981',
  'variables' => 
  array (
    'dni' => 0,
    'usuarios' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56039a16281903_96031850',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56039a16281903_96031850')) {
function content_56039a16281903_96031850 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '819056039a1623b3f1_18764981';
?>
<div class="row">
    <div class="well well-sm col-xs-12 col-md-6 col-md-push-3">
        <a href="javascript:history.back();" 
           class="visible-md visible-lg close close-login text-warning" data-dismiss="alert" aria-label="close" title="Volver sin guardar">
            &times;</a>

        <form role="form" class="form-horizontal" action="" method="post">     
            <input type="hidden" name="guardar" value="1" />
            <div class="col-md-12">  
                <div class="form-group ">
                    <label for="dni" class="control-label col-md-3">NIF/NIE</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-addon glyphicon glyphicon-barcode"></span>
                            <input type="text" class="form-control" name="dni" id="dni" placeholder="Introduzca DNI/NIE" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['dni']->value)===null||$tmp==='' ? '' : $tmp);?>
" autofocus>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"></div>
            <a href="javascript:history.back();" 
               class="hidden-md hidden-lg col-xs-5 btn btn-warning" title="Volver sin guardar">
                Volver</a>
            <input type="submit" class="hidden-md hidden-lg col-xs-5 pull-right  btn btn-success" value="Continuar"/>
            <input type="submit" class="visible-lg btn btn-success form-control" value="Continuar"/>

    </div>
</form>
</div>
<div class="col-md-6 col-md-push-3">
    <hr/>
    <h2>
        Usuarios inscritos

    </h2>
    <?php if (isset($_smarty_tpl->tpl_vars['usuarios']->value) && count($_smarty_tpl->tpl_vars['usuarios']->value)) {?>
        <table class="table table-striped table-hover table-condensed">
            <thead class="bg-primary">
                <tr>
                    <th></th>
                    <th>DNI</th>
                    <th class="hidden-xs">Nombre</th>
                    <th>Telefono</th>
                        
                    <th></th>
                </tr>
            </thead>
            
            <?php
$_from = $_smarty_tpl->tpl_vars['usuarios']->value;
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
                    <td class="text-info small">
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['row'];?>

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
                    <td>
                        <a class="btn btn-primary btn-round" href="<?php echo BASE_URL;?>
aula_usuarios/ver/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" title="Ver ficha del alumno">
                            <i class=" glyphicon glyphicon-eye-open"></i>
                        </a>
                    </td>
                </tr>
            <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
        </table>
    <?php } else { ?>
        <div class="alert alert-warning">
            No hay alumnos matriculados
        </div>
    <?php }?>
</div><?php }
}
?>