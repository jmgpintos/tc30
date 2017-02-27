	
<!DOCTYPE html>
<html lang="es" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{strip_tags($titulo)|default:$_layoutParams.configs.app_name}</title>
        {*        <title>{$titulo}</title>*}
        <!--<link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css'] ?>estilo.css">-->
        <link rel="stylesheet" href="{$_layoutParams.ruta_css}bootstrap.css">
        {*        <link rel="stylesheet" href="{$_layoutParams.ruta_css}sandstone.min.css">*}
        <link rel="stylesheet" href="{$_layoutParams.ruta_css}font-awesome.min.css">
        <link rel="stylesheet" href="{$_layoutParams.ruta_css}estilo.css">
        <link rel="stylesheet" href="{$_layoutParams.ruta_css}jquery-ui.css">
        <link rel="shortcut icon" type="image/x-icon" href="{$_layoutParams.ruta_img}agencia.ico">
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{$_layoutParams.root}"><span class="label label-default text-default">{$_layoutParams.configs.app_name}</span></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {if isset($_layoutParams.menu)}
                        {foreach item=menu from=$_layoutParams.menu}
                            {if $menu.id=='separador'}
                                <li role="separator" class="divider"></li>
                                {else}
                                    {if isset($menu.submenu)}
                                        {if isset($_layoutParams.item) && $_layoutParams.item == $menu.id}
                                            {assign var='_clase' value = 'active'}
                                        {else}
                                            {assign var='_clase' value = ''}
                                        {/if}
                                    <li class="{$_clase} dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="{$menu.enlace}">{$menu.titulo}
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            {foreach item=sub from=$menu.submenu}
                                                {if $sub.id=='separador'}
                                                    <li role="separator" class="divider"></li>
                                                    {else}
                                                    <li ><a href="{$sub.enlace}">{$sub.titulo}</a></li>
                                                    {/if}
                                                {/foreach}
                                        </ul>
                                    </li>
                                {else}
                                    {if isset($_layoutParams.item) && $_layoutParams.item == $menu.id}
                                        {assign var='_clase' value = 'active'}
                                    {else}
                                        {assign var='_clase' value = ''}
                                    {/if}
                                    <li class="{$_clase}"><a href="{$menu.enlace}">{$menu.titulo}</a></li>
                                    {/if}
                                {/if}
                            {/foreach}
                        {/if}
                </ul>
                {*            <li role="separator" class="divider"></li>*}
                <ul class="nav navbar-nav navbar-right">
                    {if isset($_layoutParams.menu_right)}
                        {foreach item=menu from=$_layoutParams.menu_right}
                            {if $menu.id=='separador'}
                                <li role="separator" class="divider"></li>
                                {else}
                                    {if isset($menu.submenu)}
                                        {if isset($_layoutParams.item) && $_layoutParams.item == $menu.id}
                                            {assign var='_clase' value = 'active'}
                                        {else}
                                            {assign var='_clase' value = ''}
                                        {/if}
                                    <li class="{$_clase} dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="{$menu.enlace}">{$menu.titulo}
                                            <span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                            {foreach item=sub from=$menu.submenu}
                                                {if $sub.id=='separador'}
                                                    <li role="separator" class="divider"></li>
                                                    {else}
                                                    <li ><a href="{$sub.enlace}">{$sub.titulo}</a></li>
                                                    {/if}
                                                {/foreach}
                                        </ul>
                                    </li>
                                {else}
                                    {if isset($_layoutParams.item) && $_layoutParams.item == $menu.id}
                                        {assign var='_clase' value = 'active'}
                                    {else}
                                        {assign var='_clase' value = ''}
                                    {/if}
                                    <li class="{$_clase}"><a href="{$menu.enlace}">{$menu.titulo}</a></li>
                                    {/if}
                                {/if}
                            {/foreach}
                        {/if}
                </ul>
            </div><!--/.nav-collapse -->
        </nav>
        <div class="container-fluid">
            {if isset($titulo)}
                <div class="page-header">
                    <h1>
                        {$titulo|default:$_layoutParams.configs.app_name}
                        {if isset($cuenta)}<span class="badge">{$cuenta}</span>{/if}
                    </h1>
                </div>
            {/if}
            <div class="container">
                {*<div class="col-md-12">
                </div>*}
                <noscript> 
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span><strong>Atención: </strong> JavaScript está deshabilitado. <a target="_blank" href="http://enable-javascript.com/es/" class="alert-link">Habilite Javascript para el buen funcionamiento de la aplicación</a>.</span>
                </div>
                </noscript> 
                {if isset($error)}
                    <!--Mensajes generales-->
                    <div class="row">
                        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <h3>Atenci&oacute;n</h3> <hr>
                            {$error}
                        </div>
                    </div>
                {/if}

                {if isset($mensaje)}
                    <!--Mensajes generales-->
                    <div class="row">
                        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            {$mensaje}
                        </div>
                    </div>
                {/if}

                {* {if isset($_error)}
                <!--Mensajes privados de cada controlador-->
                <div class="row">
                <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                <h3>Atenci&oacute;n</h3> <hr> 
                {$_error}
                </div>
                </div>
                {/if}*}

                {*     {if isset($_mensaje)}
                <!--Mensajes privados de cada controlador-->
                <div class="row">
                <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                <div class="text-center">
                privado{$_mensaje}
                </div>
                </div>
                </div>
                {/if}*}
                <div id="template">
                    {include file=$_contenido}
                    <div id="version">
                        v: <span class="badge">{VERSION_MAJOR}.{VERSION_MINOR}.{VERSION_PATCH}</span>
                    </div>
                </div>
            </div><!--cuerpo-->
        </div><!--container-->

        {if ((Session::esAdmin() || Session::getId()==31))}
            <footer class='hidden-xs footer col-md-12 text-center bg-success ' style='margin-top:15px;padding:5px;'>
                <strong>ROOT:</strong> {ROOT} | <strong>BASE_URL:</strong> {BASE_URL}<br>{info_sesion(' | ')}
                <div class="">
                    <h4>
                        {$_layoutParams.configs.app_slogan}<br>
                        <small>{$_layoutParams.configs.app_company}</small>
                    </h4>
                </div>
            </footer>
        {else}
            {include file=$_layoutParams.footer}
        {/if}
    </body>
    <script src="{$_layoutParams.root}public/js/jquery.js"></script>
    <script src="{$_layoutParams.root}public/js/modernizr.custom.js"></script>
    <script src="{$_layoutParams.ruta_js}bootstrap.min.js"></script>
    <script src="{$_layoutParams.root}public/js/jquery.validate.js"></script>
    <script src="{$_layoutParams.root}public/js/scripts.js"></script>
    <script src="{$_layoutParams.root}public/js/login.js"></script>
    {if isset($_layoutParams.js) && count($_layoutParams.js)}
        {foreach item=js from=$_layoutParams.js}
            <script src="{$js}"></script>
        {/foreach}
    {/if}
    
    <script>
        console.log($('footer').height());
    </script>

</html>