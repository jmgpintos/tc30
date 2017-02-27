<?php

/*
 * ------------------------------
 * framework mvc básico
 * Request.php
 * ------------------------------
 */

class Request {

    private $_controlador;
    private $_metodo;
    private $_argumentos;
    private $_pilaLlamadas;

    public function __construct($bootstrap = TRUE) {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

        if (empty($url)) {
            $url = DEFAULT_CONTROLLER . '/' . DEFAULT_METHOD;
        }

        if($bootstrap) {
            $this->_construirPilaDeLlamadas($url);
        }
        $url = explode('/', rtrim($url, '/'));

        $this->_controlador = strtolower(array_shift($url));
        $this->_metodo = strtolower(array_shift($url));
        $this->_argumentos = $url;

        if (!isset($this->_argumentos)) {
            $this->_argumentos = array();
        }
    }

    function get_controlador() {
        return $this->_controlador;
    }

    function get_metodo() {
        return $this->_metodo;
    }

    function get_argumentos() {
        return $this->_argumentos;
    }

    private function _construirPilaDeLlamadas($url) {
        $this->_pilaLlamadas = Session::get('pilaLlamadas');

        if (!$this->_pilaLlamadas) {
            $this->_pilaLlamadas = array('');
        }

        if (count($this->_pilaLlamadas) > 9) {
            array_pop($this->_pilaLlamadas);
        }

        if ($this->_pilaLlamadas[0] != $url) {
            array_unshift($this->_pilaLlamadas, $url);
        }

        Session::set('pilaLlamadas', $this->_pilaLlamadas);
//        vardump(Session::get('pilaLlamadas'));
//        put($url);
    }

}
