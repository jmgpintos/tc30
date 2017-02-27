<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title><?php if (isset($this->titulo)) echo $this->titulo; ?></title>
        <!--<link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css'] ?>estilo.css">-->
        <link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css'] ?>bootstrap.css">
        <link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css'] ?>estilo.css">
        <script src="<?php echo BASE_URL; ?>public/js/jquery.js"></script>
        <script src="<?php echo BASE_URL; ?>public/js/jquery.validate.js"></script>
        <script src="<?php echo BASE_URL; ?>public/js/scripts.js"></script>
        <?php if (isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
            <?php foreach ($_layoutParams['js'] as $script): ?>
                <script src="<?php echo $script ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
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
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>"><span class="label label-default text-default"><?php echo APP_NAME; ?></span></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <?php if (isset($_layoutParams['menu'])): ?>
                        <?php foreach ($_layoutParams['menu'] as $elementoMenu): ?>
                            <?php
                            if ($elementoMenu['id'] == $item) {
                                $clase = 'active';
                            } else {
                                $clase = "";
                            }
                            ?>
                            <li class="<?php echo $clase; ?>"><a href="<?php echo $elementoMenu['enlace'] ?>"><?php echo $elementoMenu['titulo'] ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_layoutParams['menu_right'])): ?>
                        <?php foreach ($_layoutParams['menu_right'] as $elementoMenu): ?>
                            <?php
                            if ($elementoMenu['id'] == $item) {
                                $clase = 'active';
                            } else {
                                $clase = "";
                            }
                            ?>
                            <li class="<?php echo $clase; ?>">
                                <!--<a href="<?php // echo BASE_URL.'user/user/'.Session::get('id_usuario')   ?>"><?php // if(isset($elementoMenu['nombre'])) echo $elementoMenu['nombre'];   ?></a>-->
                                <a href="<?php echo $elementoMenu['enlace'] ?>">
                                    <?php echo $elementoMenu['titulo'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div><!--/.nav-collapse -->
        </nav>
        <div class="container-fluid">
            <?php if (isset($this->titulo)): ?>
                <div class="page-header ">
                    <h1><?php echo isset($this->titulo) ? $this->titulo : APP_NAME; ?></h1>
                </div>
            <?php endif; ?>
            <div class="container">
                <div class="col-md-12">
                </div>
                <noscript> 
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <span><strong>Atención: </strong> JavaScript está deshabilitado. <a target="_blank" href="http://enable-javascript.com/es/" class="alert-link">Habilite Javascript para el buen funcionamiento de la aplicación</a>.</span>
                </div>
                </noscript> 
                <!--Mensajes generales-->
                <?php if (isset($this->error)): ?>
                    <div class="row">
                        <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Atenci&oacute;n</strong> - 
                            <?php echo $this->error; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($this->mensaje)): ?>
                    <div class="row">
                        <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->mensaje; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!--Mensajes privados de cada controlador-->
                <?php if (isset($this->_error)): ?>
                <div class="row">
                    <div class="alert alert-danger col-md-6 col-md-push-3 fade in">
                        <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                        <h2 >             
                            <div class="col-md-2">
                                <span class="glyphicon glyphicon-alert"></span>
                            </div>
                            <div class="col-md-10">
                                Atenci&oacute;n
                                <hr>
                            </div>
                        </h2>
                            <div class="col-md-10 col-md-push-2">                        
                            <?php echo $this->_error; ?>
                            </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>


            <?php if (isset($this->_mensaje)): ?>
                <div class="row">
                    <div class="alert alert-success col-md-6 col-md-push-3 fade in">
                        <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
                        <h2 >             
                            <div class="col-md-2">
                                <span class="glyphicon glyphicon-info-sign"></span>
                            </div>
                            <div class="col-md-10">
                                Informaci&oacute;n
                                <hr>
                            </div>
                        </h2>
                            <div class="col-md-10 col-md-push-2">                        
                            <?php echo $this->_mensaje; ?>
                            </div>
                    </div>
                </div>
            <?php endif; ?>