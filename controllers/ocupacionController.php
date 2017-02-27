<?php

include ROOT . 'controllers' . DS . 'variosController.php';

class ocupacionController extends variosController {

    protected $_table = 'ocupacion';
    protected $_modulo = 'ocupacion';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('varios');

        $this->_nombreCampo_ = 'ocupaci&oacuten';
        $this->_placeholder_ = 'Nueva ocupación';
    }

    public function index($pagina = 1)
    {
        $titulo = 'Ocupaciones';
        parent::index($pagina, $titulo);
    }

    public function nuevo()
    {
        parent::nuevo();
    }
}