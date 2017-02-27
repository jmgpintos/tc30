<?php

class postController extends Controller {

    protected $_model;
    protected $_modulo = 'post';
    protected $_table = 'posts';
    private $lineas_por_pagina = 6;

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel($this->_modulo);
        $this->_mensaje = Session::get('mensaje');
        $this->_error = Session::get('error');
    }

    public function index($pagina = false)
    {
//        Session::acceso('usuario');
//        $this->_model->temp_insertar_posts();

//        if (!$this->filtrarInt($pagina)) {
//            $pagina = 1;
//        } else {
//            $pagina = (int) $pagina;
//        }
//
//        try {
//            $this->getLibrary('paginador');
//            $paginador = new Paginador();
//
//            $this->_view->assign('_mensaje', $this->_mensaje ? $this->_mensaje : null);
//            Session::destroy('mensaje');
//
//            $this->_view->assign('posts', $paginador->paginar($this->_model->getPosts(), $pagina, $this->lineas_por_pagina));
//            $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
//            $this->_view->assign('titulo', 'Listado de posts');
//            $this->_view->assign('pagina', $pagina);
//            $this->_view->assign('cuenta', $this->_model->getCount($this->_table));
//
//            $this->_view->renderizar_template('index', $this->_modulo);
//        } catch (Exception $exc) {
//            $this->saltar_error(805);
//        }
    }

    public function nuevo()
    {
//        Session::accesoEstricto(array('especial'));

//        $this->_view->assign('titulo', 'Nuevo post');
//        $this->_view->setJs(array('nuevo', 'file_input'));
//        if ($this->getInt('guardar') == 1) {
//            $this->_view->assign('datos', $_POST);
//            if (!$this->getTexto('titulo')) {
//                $this->_view->assign('error', 'Debe introducir el titulo del post');
//                $this->_view->renderizar_template('nuevo', $this->_modulo);
//                exit;
//            }
//            if (!$this->getTexto('cuerpo')) {
//                $this->_view->assign('error', 'Debe introducir el cuerpo del post');
//                $this->_view->renderizar_template('nuevo', $this->_modulo);
//                exit;
//            }
//
//            $imagen = '';
//            $this->getLibrary('upload' . DS . 'class.upload');
//            $ruta = ROOT . 'public' . DS . 'img' . DS . 'post' . DS;
//
//
//            if (isset($_FILES['imagen']['name'])) {
//                $ruta_imagenes = ROOT . 'public' . DS . 'img' . DS . 'post';
//                $upload = subir_imagen($ruta_imagenes);
//
//                if ($upload->processed) {
//                    $imagen = $upload->file_dst_name;
//                    $thumb = new upload($upload->file_dst_pathname, 'es_ES'); //thumb para la ficha
//                    $thumb_list = new upload($upload->file_dst_pathname, 'es_ES'); //thumb para el listado
//                    $thumb->image_resize = $thumb_list->image_resize = true;
//                    $thumb->image_ratio = $thumb_list->image_ratio = true;
//                    $thumb_list->image_x = 120;
//                    $thumb->image_x = 250;
//                    $thumb->file_name_body_pre = 'thumb_';
//                    $thumb_list->file_name_body_pre = 'thumb_ls_';
//                    $thumb->process($ruta . 'thumb' . DS);
//                    $thumb_list->process($ruta . 'thumb' . DS);
//                } else {
//                    $this->_view->assign('error', $upload->error);
//                    $this->_view->renderizar_template('nuevo', $this->_modulo);
//                    exit;
//                }
//            }
//
//            $this->_model->insertarPost(
//                    $this->getTexto('titulo'), $this->getTexto('cuerpo'), $imagen
//            );
//            $this->redireccionar($this->_modulo);
//        }
//
//        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    public function editar($id, $pagina)
    {
        Session::accesoEstricto(array('especial'));
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
        }

        if (!$this->_model->getById('posts', $this->filtrarInt($id))) {
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
        }
        $this->_view->assign('titulo', 'Editar post');
        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {
            $this->_view->assign('datos', $_POST || '');
            ;
            if (!$this->getTexto('titulo')) {
                $this->_view->assign('error', 'Debe introducir el titulo del post');
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }
            if (!$this->getTexto('cuerpo')) {
                $this->_view->assign('error', 'Debe introducir el cuerpo del post');
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }
            $this->_model->editarPost(
                    $this->filtrarInt($id), $this->getTexto('titulo'), $this->getTexto('cuerpo')
            );
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
        }

        $this->_view->assign('datos', $this->_model->getPost($this->filtrarInt($id)));
        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    public function eliminar($id, $pagina)
    {
        Session::acceso('admin');

        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getPost($this->filtrarInt($id))) {
            $this->redireccionar($this->_modulo);
        }

        $this->_model->eliminarRegistro($this->_table, $this->filtrarInt($id));
        Session::set('mensaje', 'Se ha eliminado el registro');
        $this->redireccionar($this->_modulo . '/index/' . $pagina);
    }
}