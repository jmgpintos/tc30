<?php

include ROOT . 'controllers' . DS . 'variosController.php';

class niveles_estudiosController extends variosController {

    protected $_table = 'niveles_estudios';
    protected $_modulo = 'niveles_estudios';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('varios');

        $this->_nombreCampo_ = 'nivel de estudios';
        $this->_placeholder_ = 'Nuevo nivel de estudios';
    }

    public function index($pagina = 1)
    {
        $titulo = 'Nivel de Estudios';
        parent::index($pagina, $titulo);
    }

    public function nuevo()
    {
        parent::nuevo();
    }
}