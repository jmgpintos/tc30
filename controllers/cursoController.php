<?php

class cursoController extends Controller {

    protected $_table = 'cursos';
    protected $_modulo = 'curso';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('curso');
    }
    /*
     * Listado de usuarios
     */

    public function index($pagina = 1)
    {
        Session::acceso('usuario');
        $pagina = $this->filtrar_pagina($pagina);


        $this->_view->setJs(array('confirmarBorrar'));

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }
        $this->asignar_mensajes();

        $datos = $this->_model->getAll();

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', 'Listado de cursos');
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    public function ver($cursoID, $pagina = 1)
    {
        Session::acceso('usuario');
        if (!$this->filtrarInt($cursoID)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getCursoById($this->filtrarInt($cursoID))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $this->filtrarInt($cursoID));
            exit;
        }

        $datos = $this->_model->getCursoById($this->filtrarInt($cursoID));
        
//vardumpy($this->_model->getCursos($id));
        $this->_view->assign('titulo', "Ficha del curso");

        $this->getLibrary('paginador');
        $paginador = new Paginador();
$cursos = $this->getCursos($cursoID);
        $this->_view->assign('datos', $datos);
        $this->_view->assign('cursos', $paginador->paginar($cursos, $pagina, LINES_PER_PAGE * 1.4));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $cursoID));
        $this->_view->assign('pagina', Session::get('pagina'));

        $this->_view->renderizar_template('ver', $this->_modulo);
    }
    
    /**
     * Crear curso
     */
    public function nuevo()
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Nuevo Curso');

        $this->_view->setJs(array('nuevo','initTinyMCE'));

        $categorias = $this->_model->getCategorias();
        array_unshift($categorias, array(
            'id' => '0',
            'nombre' => ''));
        $this->_view->assign('categorias', $categorias);

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);
            if (!$this->comprobar_datos('nuevo')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            //Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                ':nombre' => $this->getPostParam('nombre'),
                ':id_categoria' => $this->getPostParam('id_categoria'),
                ':descripcion' => $this->getPostParam('descripcion'),
                ':requisitos' => $this->getPostParam('requisitos'),
                ':especial' => $this->getPostParam('especial'),
                ':creador' => Session::getId()
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
            $id = $this->_model->getLastID();

            $url = BASE_URL . $this->_modulo . '/ver/' . $id;
            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong><a href = "' . $url . '">' . $this->getPostParam('nombre') . '</a></strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('editar', $this->_modulo);
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

        if (!$this->_model->getCursoById($this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $id);
            exit;
        }

        $this->_view->assign('titulo', "Editar curso");
        $this->_view->setJs(array('nuevo','initTinyMCE'));


        $this->_view->assign('categorias', $this->_model->getCategorias());
//        vardumpy($this->_model->getCategorias());

        if ($this->getInt('guardar') == 1) {

//            vardumpy($_POST);
            $this->_view->assign('datos', $_POST);

//            if (!$this->comprobar_datos('editar')) {
//                $this->_view->renderizar_template('editar', $this->_modulo);
//                exit;
//            }

            $especial = $this->getPostParam('especial') == 'on' ? 1 : 0;
            $campos = array(
                ':nombre' => $this->getPostParam('nombre'),
                ':id_categoria' => $this->getInt('id_categoria'),
                ':descripcion' => $this->getPostParam('descripcion'),
                ':requisitos' => $this->getPostParam('requisitos'),
                ':especial' => $especial,
//                ':fecha_modificacion' => ahora(),
//                ':modificador' => Session::getId(),
            );

            $this->_model->editarRegistro($this->_table, $id, $campos);
            if ($id == Session::getId()) {
                Session::set('nombre', $this->getPostParam('nombre'));
            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">' .
                    $this->getPostParam('nombre') .
                    '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getCursoById(
                        $this->filtrarInt($id)));
//        vardumpy( $this->_model->getCursoById($this->filtrarInt($id)));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Eliminar dinamizador con id = $id
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {
//        Session::acceso('admin');
        $curso = $this->_model->getCursoById($id);
        $nombre = $curso['nombre'];
//puty($nombre);
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

        //Comprobaciones comunes
        if (!$this->getSql('nombre')) {
            $err = 'Debe introducir el nombre del curso';
        } elseif ($this->getPostParam('id_categoria') < 1) {
            $err = "Seleccione una categoría";
        }

        //comprobaciones para cada caso
        if (is_null($err)) {
            if ($accion === 'editar') {
//                $err = $this->comprobar_datos_editar();
            } elseif ($accion === 'nuevo') {
                $err = $this->comprobar_datos_nuevo();
            }
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function comprobar_datos_nuevo()
    {
        $err = null;

        $campos = array('nombre' => $this->getAlphaNum('nombre'));
        if ($this->_model->existeRegistro($this->_table, $campos)) {
            $err = "Ya existe un curso con este nombre <strong>" . $this->getAlphaNum('nombre') . "</strong>";
        }

        return $err;
    }

//    public function comprobar_datos_editar()
//    {
//        $err = null;
//        $this->_model->buscarRegistro('', array());
//        $table = 'alumnos';
//        $busqueda = array(
//            array('nombre', '=', 'pepe'),
//            array('apellidos', ' = ', 'garcia')
//        );
//        if (!$this->_model->existe_registro(
//                        $this->_table, array('dni' => $this->getAlphaNum('dni'))
//                )) {
//            $err = 'Ya existe un alumno con este dni/nie';
//        }
//        return $err;
//    }
//    public function limpiar_busqueda()
//    {
//        Session::destroy('rs');
//        Session::destroy('buscar');
//    }

//    public function asignar_mensajes()
//    {
//        puty($this->_mensaje);
//        
//        $this->_view->assign('_mensaje', $this->_mensaje ? $this->_mensaje : null);
//        $this->_view->assign('_error', $this->_error ? $this->_error : null);
//        Session::destroy('mensaje');
//        Session::destroy('error');
//    }

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
//    public function formato_datos($datos)
//    {
//
//        $datos['dni'] = strtoupper($datos['dni']);
//        $datos['fechaNac'] = fecha_completa($datos['fechaNac']);
//        $datos['telefono'] = formato_telefono(($datos['telefono']));
//        return $datos;
//    }

    public function getCursos($cursoID)
    {
        
        $id = $this->filtrarInt($cursoID);
        $cursos = $this->_model->getCursos($cursoID);

        for ($index = 0; $index < count($cursos); $index++) {
            $cursos[$index]['row'] = $index + 1;
        }

        return $cursos;
    }
    
    }