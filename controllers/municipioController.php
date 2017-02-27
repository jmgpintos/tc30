<?php

include ROOT . 'controllers' . DS . 'variosController.php';

class municipioController extends variosController {

    protected $_table = 'municipios';
    protected $_modulo = 'municipio';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('varios');

        $this->_nombreCampo_ = 'municipio';
        $this->_placeholder_ = 'Nuevo municipio';
    }

    public function index($pagina = 1)
    {
        $titulo = 'Municipios';
        parent::index($pagina, $titulo);
    }

    public function nuevo()
    {
        parent::nuevo();
    }
}