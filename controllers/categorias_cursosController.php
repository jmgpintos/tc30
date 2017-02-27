<?php

include ROOT . 'controllers' . DS . 'variosController.php';

class categorias_cursosController extends variosController {

    protected $_table = 'categorias_cursos';
    protected $_modulo = 'categorias_cursos';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('varios');
        
        $this->_nombreCampo_ = 'Categor&iacutea';
        $this->_placeholder_ = 'Nueva Categoría';
    }

    public function index($pagina = 1)
    {
        $titulo = 'Categorías de Cursos';
        parent::index($pagina, $titulo);
    }

    public function nuevo()
    {

        parent::nuevo();
    }
}