<?php /* Smarty version 3.1.24, created on 2015-09-24 14:55:08
         compiled from "C:/xampp/htdocs/tc30/views/layout/default/footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:161935603f2ac274592_80011644%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa2b1ea2090a14366271126d9b7375241d8dd303' => 
    array (
      0 => 'C:/xampp/htdocs/tc30/views/layout/default/footer.tpl',
      1 => 1443099291,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161935603f2ac274592_80011644',
  'variables' => 
  array (
    '_layoutParams' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_5603f2ac2ca4a0_41786861',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5603f2ac2ca4a0_41786861')) {
function content_5603f2ac2ca4a0_41786861 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '161935603f2ac274592_80011644';
?>
<footer id="pie" class=" bg-success text-default"> 

    <div id="contenedor" class="col-md-12">	

            <div class="columna col-md-3"> 
                <p>©2014 Agencia de Desarrollo</p>

                <p style="font-size:12px;">C/ Magallanes, nº 30 (Villaflorida)<br>
                    Santander, Cantabria.<br>
                    Tlf: 942 20 30 30<br>
                    Fax: 942 20 30 33<br>
                    E-mail: <a href="mailto:adl@ayto-santander.es">adl@ayto-santander.es</a></p>
            </div>
            <div class="columna col-md-3 text-center">
                    <a href="http://www.campussantanderemprende.com/redtelecentros" 
                       title="Enlace a web de telecentros" target="_blank">
                        <img class="img-responsive" src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
logo_telecentros.png">
                    </a>
                    
            </div>
            <div class="columna col-md-3 text-center"> <br/>
                <h4 class="text-success">Conecta con nosotros</h4>
                <div class="redes">
                    <a href="https://www.facebook.com/pages/Agencia-de-Desarrollo-de-Santander/306926076019712" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
redes/redes-facebook.png" alt="" /></a>
                    <a href="https://twitter.com/adSantander" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
redes/redes-twitter.png" alt="" /></a>
                    <a href="https://plus.google.com/101647296771144198863/about" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
redes/redes-google.png" alt="" /></a>
                    <a href="https://www.youtube.com/user/ADSantander" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
redes/redes-youtube.png" alt="" /></a>
                    <a href="http://wordpress.campussantanderemprende.com/" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['ruta_img'];?>
redes/redes-wordpress.png" alt="" /></a>
                </div>
                <div class="redes">
                </div>
            </div>
            <div class="columna col-md-3"> 
                    <br/>
                    <h4 class="alert  alert-info text-center ">
                        <?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_slogan'];?>
<br>
                        <small><?php echo $_smarty_tpl->tpl_vars['_layoutParams']->value['configs']['app_company'];?>
</small>
                    </h4>
            </div>
        </div>


</footer> <?php }
}
?>