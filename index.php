<?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(-1);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
//define('ROOT', '/home/tatooine/NetBeansProjects/MVC' . DS);
//echo ROOT;
define('APP_PATH', ROOT . 'application' . DS);
define('LIB_PATH', ROOT . 'libs' . DS);

try {
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Request.php';
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'Model.php';
    require_once APP_PATH . 'View.php';
    require_once APP_PATH . 'Registro.php';
    require_once APP_PATH . 'Database.php';
    require_once APP_PATH . 'Session.php';
    require_once APP_PATH . 'Log.php';
    require_once APP_PATH . 'Preferencias.php';

    require_once APP_PATH . 'Hash.php';
    require_once LIB_PATH . 'php/helper-functions.php';
    require_once LIB_PATH . 'php/validadores.php';
    require_once LIB_PATH . 'php/f_datetime.php';
    require_once LIB_PATH . 'php/f_string.php';
    require_once LIB_PATH . 'php/string.class.php';


//vardump(get_required_files());
//    echo Hash::getHash('SHA1', '1234', HASH_KEY);die; //41fc4b552b937a7b69612d768791a7c62c35890c

    Session::init();
    if (Session::esEspecial()) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(-1);
    }
    

//    vardump(__FILE__ . ' - '. __METHOD__);
    Bootstrap::run(new Request());
} catch (Exception $e) {
    echo $e->getMessage();
    echo '<br>Linea: ' . $e->getLine() . ' ' . $e->getFile();
}