<?php /* Smarty version 3.1.24, created on 2015-09-24 20:17:30
         compiled from "F:/xampp/htdocs/tc30/views/layout/default/footer.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:1809156043e3a739651_15636869%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '638036d2af53b087754c011fc9e0697ad2bc9621' => 
    array (
      0 => 'F:/xampp/htdocs/tc30/views/layout/default/footer.tpl',
      1 => 1443099292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1809156043e3a739651_15636869',
  'variables' => 
  array (
    '_layoutParams' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.24',
  'unifunc' => 'content_56043e3a781ab6_03752914',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56043e3a781ab6_03752914')) {
function content_56043e3a781ab6_03752914 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '1809156043e3a739651_15636869';
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