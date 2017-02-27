<?php

class centroController extends Controller {

    protected $_table = 'centros';
    protected $_modulo = 'centro';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('centro');
    }

    /*
     * Listado de usuarios
     */

    public function index($pagina = 1)
    {
        Session::acceso('usuario');
        $pagina = $this->filtrar_pagina($pagina);
        $this->limpiar_busqueda();

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }
        $this->asignar_mensajes();

        $datos = $this->_model->getAll($this->_table);
        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index] = $this->formato_datos($datos[$index]);
        }
//        vardumpy($datos);

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', 'Listado de centros');
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    public function ver($id, $pagina = 1)
    {
        Session::acceso('usuario');
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $this->filtrarInt($id));
            exit;
        }

        $datos = $this->_model->getById($this->_table, $this->filtrarInt($id));
        $equipos = $this->_model->getEquiposPorCentro($id);
        for ($i = 0; $i < count($equipos); $i++) {
            $equipos[$i]['row'] = $i + 1;
        }

        $this->getLibrary('paginador');
        $paginador = new Paginador();
        $this->_view->assign('titulo', "Ficha del centro");

        $this->_view->assign('datos', $datos);
        $this->_view->assign('equipos', $equipos);

        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $id));
        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    /**
     * Crear usuario
     */
    public function nuevo()
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Nuevo centro');

        $this->_view->setJs(array('file_input'));

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);

            $this->_view->assign('datos', $_POST);
            if (!$this->comprobar_datos('nuevo')) {
                $this->_view->renderizar_template('nuevo', $this->_modulo);
                exit;
            }

            //Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                ':nombre' => $this->getPostParam('nombre'),
                ':direccion' => $this->getPostParam('direccion'),
                ':telefono' => $this->getPostParam('telefono'),
                ':aforo' => $this->getInt('aforo'),
                ':coordenadas' => $this->getPostParam('coordenadas'),
                ':mapa' => $this->getPostParam('mapa')
                    )
            );

            //Comprobar si se ha escrito el registro en la tabla
            if (!$this->_model->existeRegistro(
                            $this->_table, array('nombre' => $this->getAlphaNum('nombre'))
                    )) {
                $this->_view->assign('_error', 'Error al registrar el usuario');
                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);
            $busqueda = array(array('nombre', '=', $this->getPostParam('nombre')));

            $registro = $this->_model->buscarRegistro($this->_table, $busqueda);
            $id = $registro[0]['id'];
//            puty($id);

            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong><a href="' . $url . '">'
                    . $this->getPostParam('nombre') . '</strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    /**
     * Editar dinamizador con id = $id
     * @param int $id
     */
    public function editar($id)
    {
        Session::acceso('especial');
//        Session::set('editando_id', $id);
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $id);
            exit;
        }

        $this->_view->assign('titulo', "Editar centro");
        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->comprobar_datos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':nombre' => $this->getPostParam('nombre'),
                ':direccion' => $this->getPostParam('direccion'),
                ':telefono' => $this->getPostParam('telefono'),
                ':aforo' => $this->getInt('aforo'),
                ':fundacion' => $this->getInt('fundacion'),
                ':coordenadas' => $this->getPostParam('coordenadas'),
                ':mapa' => $this->getPostParam('mapa')
            );

            $this->_model->editarRegistro($this->_table, $id, $campos);
//            if ($id == Session::getId()) {
//                Session::set('nombre', $this->getPostParam('nombre'));
//            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">'
                    . $this->getPostParam('nombre')
                    . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($id)));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Eliminar dinamizador con id = $id
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {
        Session::acceso('admin');
        $centro = $this->_model->getById($this->_table, $id);
        $nombre = $centro['nombre'];


        Session::set('nombre_borrado', $nombre);
        parent::eliminar($id, $this->_modulo);
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
        //Comprobaciones comunes
        if (!$this->getSql('nombre')) {
            $err = 'Debe introducir el nombre del centro';
        } elseif (!$this->getInt('aforo')) {
            $err = 'Debe introducir un aforo correcto';
        }

        //comprobaciones para cada caso
        if (is_null($err)) {
            if ($accion === 'nuevo') {
                $err = $this->comprobar_datos_nuevo();
            }
        }

        if ($err) {
            $this->_view->assign('_error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function comprobar_datos_nuevo()
    {
        $err = null;

        if ($this->_model->existeRegistro(
                        $this->_table, array(
                    'nombre' => $this->getTexto('nombre'))
                )) {
            $err = 'El centro <em><strong>' . $this->getAlphaNum('usuario') . '</strong></em> ya existe';
        }

        return $err;
    }

    public function limpiar_busqueda()
    {
        Session::destroy('rs');
        Session::destroy('buscar');
    }

    public function asignar_mensajes()
    {

        $this->_view->assign('_mensaje', $this->_mensaje ? $this->_mensaje : null);
        $this->_view->assign('_error', $this->_error ? $this->_error : null);
        Session::destroy('mensaje');
        Session::destroy('error');
    }

    public function filtrar_pagina($pagina)
    {

        if (!$this->filtrarInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }
        return $pagina;
    }

    /**
     * Función para crear nuevos dinamizadores automáticamente
     * 
     *                      PARA PRUEBAS
     */
    public function nuevo_auto()
    {
        $this->_model->nuevo_alumno_auto();
        $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
    }

    public function formato_datos($datos)
    {

//        $datos['dni'] = strtoupper($datos['dni']);
//        $datos['fechaNac'] = fecha_completa($datos['fechaNac']);
        $datos['telefono'] = formato_telefono(($datos['telefono']));
        return $datos;
    }

    public function p()
    {
        $t = $this->_model->p();

//        vardumpy($tablas);
        for ($i = 0; $i < count($t); $i++) {
            if (!endsWith($t[$i] ["Tables_in_mvc"], 'bak')) {
                $tablas[] = $t[$i] ["Tables_in_mvc"];
            }
        }

        vardump($tablas);

        //recorrer tablas y sacar campos 
    }

}
