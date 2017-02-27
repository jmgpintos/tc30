<?php /* Smarty version 3.1.24, created on 2015-09-24 14:40:08
         compiled from "C:/xampp/htdocs/tc30/views/log/ver.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:210465603ef28dd4b64_92648615%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40977682c343b75012d52775c29ea62bd80235c2' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/log/ver.tpl',
      1 => 1441994934,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '210465603ef28dd4b64_92648615',
  'variables' => 
  array (
    'datos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603ef28e70f97_86237741',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603ef28e70f97_86237741')) {
function content_5603ef28e70f97_86237741 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '210465603ef28dd4b64_92648615';
?>




    
    
     

<div class="row">
    <div class="well well-sm col-md-8 col-md-push-2">
        <a href="<?php echo BASE_URL;?>
log/index/<?php echo Session::get('pagina');?>
" 
           class="close close-login text-warning" data-dismiss="alert" aria-label="close">&times;</a>

        <div class="row col-md-12"> 
            <br/>
            <label class="control-label col-md-2">Nivel</label>
            <i class="col-md-1 glyphicon glyphicon-home"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['nivel'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Equipo</label>
            <i class="col-md-1 glyphicon glyphicon-console"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['equipo'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">ip</label>
            <i class="col-md-1 glyphicon glyphicon-chevron-right"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['ip'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Tiempo:</label>
            <i class="col-md-1 glyphicon glyphicon-time"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['tiempo'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">Mensaje:</label>
            <i class="col-md-1 glyphicon glyphicon-calendar"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['mensaje'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>


            <label class="control-label col-md-2">M&eacute;todo:</label>
            <i class="col-md-1 glyphicon glyphicon-pencil"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['metodo'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>
            <br/>

            <label class="control-label col-md-2">Contexto:</label>
            <i class="col-md-1 glyphicon glyphicon-ok"></i>
            <div class="col-md-9">
                <?php echo (($tmp = @$_smarty_tpl->tpl_vars['datos']->value['contexto'])===null||$tmp==='' ? '' : $tmp);?>

            </div>
            <div class="row"></div>

            <hr/>
        </div>

        <a class="col-md-4 col-md-push-4 btn btn-warning" href="<?php echo BASE_URL;?>
log/index/<?php echo Session::get('pagina');?>
" >Volver</a>
    </div>

</div>






<?php }
}
?>