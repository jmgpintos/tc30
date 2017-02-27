<?php

class Bootstrap {

    public static function run(Request $peticion)
    {
        $controller = $peticion->get_controlador() . 'Controller';
        $metodo = $peticion->get_metodo();
        $args = $peticion->get_argumentos();
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';

//        put($rutaControlador);exit;
        if (is_readable($rutaControlador)) {
            require_once $rutaControlador;
            $controller = new $controller;

            if (is_callable(array($controller, $metodo))) {
                $sin_metodo = false;
                $metodo = $peticion->get_metodo();
            } else {
                $sin_metodo = true;
                $metodo = DEFAULT_METHOD;
            }

            if (isset($args) && !$sin_metodo) {
                call_user_func_array(array($controller, $metodo), $args);
            } else {
                call_user_func(array($controller, $metodo));
            }
        } else {
//            require_once ROOT . 'controllers' . DS . 'errorController.php';
            header('location:'.BASE_URL.'error/access/404/'.$controller);
            exit;
//            throw new Exception("Controlador <strong>$controller</strong> no encontrado");
        }
    }
}