<?php

class ajaxController extends Controller {

    private $_ajax;

    public function __construct()
    {
        parent::__construct();
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index()
    {
        $this->_view->assign('titulo', 'Ejemplo de Ajax');
        $this->_view->setJS(array('ajax'));
        $this->_view->assign('centros', $this->_ajax->getCentros());
        $this->_view->renderizar_template('index');
    }

    public function getUsuarios()
    {
        if ($this->getInt('centro')) {
            $usuarios = $this->_ajax->getUsuarios($this->getInt('centro'));
            for ($i = 0; $i < count($usuarios); $i++) {
                $usuarios[$i]['nombre'] = $this->getNombreApellido($usuarios[$i]);
            }
//            vardump($usuarios);
            echo json_encode($usuarios);
        }
    }

//    public function insertarCiudad()
//    {
//        if ($this->getInt('usuario') && $this->getSql('centro')) {
//            $this->_ajax->insertarCiudad(
//                    $this->getSql('usuario'), $this->getInt('centro')
//            );
//        }
//    }
}
