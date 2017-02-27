<?php

class variosController extends Controller {

    protected $_nombreCampo_;
    protected $_placeholder_;

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Crear 
     */
    public function nuevo()
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Crear ' . ucwords($this->_nombreCampo_));
        $this->_view->assign('controlador', $this->_modulo);
        $this->_view->assign('nombre_campo', ucfirst($this->_nombreCampo_));
        $this->_view->assign('placeholder', ucfirst($this->_placeholder_));

        $this->_view->assign('_view', ROOT . 'views' . DS . 'varios' . DS . 'nuevo.tpl');

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);
            if (!$this->comprobar_datos('nuevo')) {
                $this->_view->renderizar_template('nuevo', 'admin');
                exit;
            }

            //Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                ':nombre' => $this->getPostParam('nombre'),
                    )
            );

            //Comprobar si se ha escrito el registro en la tabla
            if (!$this->_model->existeRegistro(
                            $this->_table, array('nombre' => $this->getAlphaNum('nombre'))
                    )) {
                $this->_view->assign('_error', 'Error al agregar registro');
                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);
            Session::set('_mensaje', 'Se ha creado un nuevo registro para <strong>' . $this->getPostParam('nombre') . '</strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('nuevo', 'admin');
    }

    public function index($page = 1, $titulo = false)
    {
        if (!$titulo) {
            $titulo = 'Listado de ' . $this->_table;
        }
        Session::acceso('especial');
        $pagina = $this->filtrar_pagina($page);

//        $this->_view->setJs(array('paginacion'), 'varios');
        $this->_view->setJs(array('paginacion', 'confirmarBorrar'),'varios');

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }
        
        Session::destroy('nombre_borrado');
        $this->asignar_mensajes();

        $datos = $this->_model->getAll($this->_table);

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);
        $this->_view->assign('_view', ROOT . 'views' . DS . 'varios' . DS . 'index.tpl');
        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));

//        $paginas = false;
        $p = $paginador->get_paginacion();
        $paginas = ($p['total'] > 1);

        $this->_view->assign('paginas', $paginas);
        $this->_view->assign('titulo', $titulo);
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', 'admin');
    }

    public function editar($id, $titulo = 'Editar')
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Editar ' . ucwords($this->_nombreCampo_));
        $this->_view->assign('controlador', $this->_modulo);
        $this->_view->assign('nombre_campo', ucfirst($this->_nombreCampo_));
        $this->_view->assign('placeholder', ucfirst(
                        implode(
                                ' ', array_slice(explode(
                                                ' ', $this->_placeholder_), 1))) . ' a editar');

        $this->_view->assign('_view', ROOT . 'views' . DS . 'varios' . DS . 'editar.tpl');

        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $id);
            exit;
        }

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->comprobar_datos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            //La estructura de todas las tablas es id + nombre
            $campos = array(
                ':nombre' => $this->getPostParam('nombre'),
            );

            $this->_model->editarRegistro($this->_table, $id, $campos);
            if ($id == Session::getId()) {
                Session::set('nombre', $this->getPostParam('nombre'));
            }

            Session::set('mensaje', 'El registro correspondiente a <strong>'
                    . $this->getPostParam('nombre')
                    . '</strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($id)));

        $this->_view->renderizar_template('nuevo', 'admin');
    }

    /**
     * Eliminar registro con id = $id
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {
        Session::acceso('especial');
        $item = $this->_model->getById($this->_table, $id);
        $nombre = $item['nombre'];

        Session::set('nombre_borrado', $nombre);
        parent::eliminar($id);
    }

    /**
     * Comprobar que los datos introducidos en los formularios son correctos
     * 
     * @param string $accion 'nuevo'|'editar' para saber qué campos se deben validar
     * @return boolean
     * 
     */
    private function comprobar_datos($accion = false)
    {
        $err = null;
        if (!$this->getSql('nombre')) {
            $err = 'Debe introducir el nombre';
        } elseif ($accion == 'nuevo') {
            if ($this->_model->existeRegistro(
                            $this->_table, array(
                        'nombre' => $this->getTexto('nombre'))
                    )) {
                $err = 'Ya existe un registro para <em><strong>' . $this->getAlphaNum('nombre') . '</strong></em>';
            }
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }
}