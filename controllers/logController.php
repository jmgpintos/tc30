<?php

class logController extends Controller {

  protected $_table = 'log';
  protected $_modulo = 'log';

  public function __construct() {
    parent::__construct();
    $this->_model = $this->loadModel('log');
  }

  /*
   * Listado de usuarios
   */

  public function index($pagina = 1) {
    Session::acceso('usuario');
    $pagina = $this->filtrar_pagina($pagina);

    $datos = $this->_model->getAll($this->_table);
    
    
    $c = count($datos);
    for ($i = 0; $i < $c; $i++) {
      $datos[$i] = $this->formato($datos[$i]);
      $datos[$i]['row'] = $c -$i;
    }
    
//    vardumpy($datos);

    $this->getLibrary('paginador');
    $paginador = new Paginador();

    $this->_view->assign('pagina', $pagina);
    Session::set('pagina', $pagina);

    $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
    $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
    $this->_view->assign('titulo', 'Log');
    $this->_view->assign('cuenta', count($datos));
    $this->_view->assign('controlador', $this->_modulo);

    $this->_view->renderizar_template('index', $this->_modulo);
  }

  public function ver($id) {
    Session::acceso('usuario');
    if (!$this->filtrarInt($id)) {
      $this->redireccionar($this->_modulo);
    }

    $datos = $this->formato($this->_model->getById('log',$id));
    
//    vardumpy($datos);

//vardumpy($this->_model->getCursos($id));
    $this->_view->assign('titulo', "log");

    $this->getLibrary('paginador');
    $paginador = new Paginador();
    
    $this->_view->assign('datos', $datos);
    
    $this->_view->renderizar_template('ver', $this->_modulo);
  }



  public function formato($dato) {
    
      
      $dato['nivel'] = Log::getNivel($dato['nivel']);
      $dato['usuario'] = $this->getNombreApellido($this->_model->getNameById('usuarios',$dato['id_usuario']));
      $dato['tiempo'] = date('H:i:s d/m/Y', strtotime($dato['tiempo']));
      
    return $dato;
  }

}
