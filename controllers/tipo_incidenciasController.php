<?php

include ROOT . 'controllers' . DS . 'variosController.php';

class tipo_incidenciasController extends variosController {

    protected $_table = 'tipo';
    protected $_modulo = 'tipo_incidencias';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('varios');

        $this->_nombreCampo_ = 'Tipo de incidencia';
        $this->_placeholder_ = 'Nuevo tipo de incidencia';
    }

    public function index($pagina = 1)
    {
        $titulo = 'Tipos de incidencias';
        parent::index($pagina, $titulo);
    }

    public function nuevo()
    {
        parent::nuevo();
    }
}