<?php

class aula_responsablesController extends Controller {
    
    const VAR_PAGE_NAME = 'pagina_responsables';

    protected $_table = 'aula_responsables';
    protected $_modulo = 'aula_responsables';
    private $_titulo;

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('aula_responsables');
        $this->_titulo = 'AULA INNOVA | ';
    }

    /**
     * Listado de alumnos
     * 
     * @param int $pag Página del listado a mostrar
     */
    public function index($pag = 1)
    {
        $this->_definirAccesoAula_();
        if (Session::get('sql')) {
            $this->resultados_busqueda(Session::get('pagina_usuarios'));
            exit;
        }
        $pagina = $this->filtrar_pagina($pag);
        Session::set(self::VAR_PAGE_NAME, $pagina);
        
        $this->_view->setJs(array('confirmarBorrar'));

        $this->_titulo .='Responsables';

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
            Session::set('mensaje', $this->_mensaje);
        }

        $this->asignar_mensajes();

//traer datos de la tabla

        $datos = $this->_model->getAll($this->_table);
        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index]['row'] = $index + 1;
            $datos[$index] = $this->_formato($datos[$index]);
        }

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina_usuarios', $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', $this->_titulo);
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Ver ficha de usuario (y subtabla con actividades)
     * 
     * @param int $idResponsable
     * @param int $pagina
     */
    public function ver($idResponsable, $pagina = 1)
    {
        $this->_definirAccesoAula_();
        $ref = null;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $ref = $_SERVER['HTTP_REFERER'];
        }
        if (!$this->filtrarInt($idResponsable)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idResponsable))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $this->filtrarInt($idResponsable));
            exit;
        }
        $this->_view->setJs(array('confirmarBorrar', 'obtenerCertificado'));

        $this->_titulo .='Ficha del responsable';
//        $this->asignar_mensajes();

        $datos = $this->_formato($this->_model->getById($this->_table, $this->filtrarInt($idResponsable)));

        $actividades = $this->_getActividades($idResponsable);
//        vardumpy($actividades);

        $this->getLibrary('paginador');
        $paginador = new Paginador();
        $paginador_actividades = null;
        if ($actividades) {
            $paginador_actividades = $paginador->paginar($actividades, $pagina, LINES_PER_PAGE);
            $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $idResponsable));
            $p = $paginador->get_paginacion();
            $this->_view->assign('paginas', ($p['total'] > 1));
        }

        $this->_view->assign('titulo', $this->_titulo);
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->assign('datos', $datos);
        $this->_view->assign('actividades', $paginador_actividades);
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));
        $this->_view->assign('ref', $ref);

        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    /**
     * Editar alumno con id = $id
     * 
     * @param int $idResponsable
     */
    public function editar($idResponsable)
    {
        $this->_definirAccesoAula_();
//        Session::set('editando_id', $id);
        if (!$this->filtrarInt($idResponsable)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idResponsable))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $idResponsable);
            exit;
        }

        $this->_titulo .='Editar responsable';

        $this->_view->assign('titulo', $this->_titulo);
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->setJs(array('datepicker'));

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':dni' => $this->getPostParam('dni'),
                ':nombre' => capitalizar($this->getPostParam('nombre')),
                ':apellidos' => capitalizar($this->getPostParam('apellidos')),
                ':telefono' => $this->getPostParam('telefono'),
                ':sexo' => substr($this->getPostParam('sexo'), 0, 1),
                ':email' => $this->getPostParam('email'),
                ':modificador' => Session::getId(),
                ':fecha_modificacion' => FechaHora::Hoy()
            );

            if (!$this->_model->editarRegistro($this->_table, $idResponsable, $campos)) {
                $err = "Error al editar registro, probablemente el NIF ya exista en la BD";
                $this->_view->assign('error', $err);
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            } else {

                if ($idResponsable == Session::getId()) {
                    Session::set('nombre', $this->getPostParam('nombre'));
                }
                $url = BASE_URL . $this->_modulo . '/ver/' . $idResponsable;

                $this->_mensaje = 'El registro correspondiente a <strong><a href="' . $url . '">'
                        . capitalizar($this->getPostParam('apellidos') . ', ' . $this->getPostParam('nombre'))
                        . '</a></strong> ha sido modificado';
                Session::set('mensaje', $this->_mensaje);
            }
//            $this->setMensaje($mensaje);

            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($idResponsable)));


        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    public function nuevo()
    {
        $this->_definirAccesoAula_();

        $this->_titulo .= "Nuevo";

        $this->_view->assign('titulo', $this->_titulo);

        $this->_view->setJs(array('form_nuevo'));

        if ($this->getInt('guardar') == 1) {
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('nuevo')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }
            //Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                'dni' => strtoupper($this->getAlphaNum('dni')),
                'nombre' => $this->getAlphaNum('nombre'),
                'apellidos' => $this->getAlphaNum('apellidos'),
                'telefono' => $this->getAlphaNum('telefono'),
                'email' => $this->getPostParam('email'),
                'sexo' => $this->getAlphaNum('sexo')
                    )
            );


//Comprobar si se ha escrito el registro en la tabla

            $idNuevoRegistro = $this->_model->getLastID();
            if (!$idNuevoRegistro) {
//            if (!$this->_model->existeRegistro($this->_table, $campos)) {
                $this->_view->assign('_error', 'Error al insertar el registro');
                puty('Error al insertar el registro');

                $this->_view->assign('_filtro', $this->_filtroTemplate);

                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);

            $url = BASE_URL . $this->_modulo . '/ver/' . $idNuevoRegistro;
            $nombre = $this->getNombreApellido($this->_model->getById($this->_table, $idNuevoRegistro));

            Session::set('mensaje', 'Se ha creado un nuevo registro para '
                    . ' <strong><a href="' . $url . '">' . $nombre . '</strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

       /**
     * Eliminar alumno con id = $id
     * 
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = Session::ROLE_AULA_INNOVA, $pagina =self::VAR_PAGE_NAME)
    {
        $alumno = $this->_model->getById($this->_table, $id);
        $nombre = $this->getNombreApellido($alumno);

        Session::set('nombre_borrado', capitalizar($nombre));
        parent::eliminar($id, $this->_modulo,$acceso, $pagina);
    }

    
    /**
     * Comprobar que los datos introducidos en los formularios son correctos
     * 
     * @param string $accion 'nuevo'|'editar' para saber qué campos se deben validar
     * @return boolean
     * 
     */
    private function _comprobarDatos($accion = false)
    {
        $err = null;

        //Comprobaciones comunes
        if (!comprobar_letra_nif($this->getAlphaNum('dni'))) {
            $err = 'NIF/NIE incorrecto';
        } elseif (!$err) {
            if (!$this->getSql('nombre') || !$this->getSql('apellidos')) {
                $err = 'Debe introducir el nombre y los apellidos del usuario';
            } elseif (!$this->validarTelefono($this->getPostParam('telefono'))) {
                $err = "Introduzca un n&uacute;mero de tel&eacute;fono correcto (9 cifras, sin espacios)";
            } elseif (!$this->validarEmail($this->getPostParam('email'))) {
                $err = "Introduzca una direcci&oacute;n de correo electr&oacute;nico correcta";
            } elseif (!array_key_exists('sexo', $_POST)) {
                $err = "Seleccione Hombre o Mujer";
            }
        }


        //comprobaciones para cada caso
//        if (is_null($err)) {
//            if ($accion === 'editar') {
//                $err = $this->comprobar_datos_editar();
//            } elseif ($accion === 'nuevo') {
//                $err = $this->comprobar_datos_nuevo();
//            }
//        }

        if ($err) {
//            puty($err);
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Devuelve los cursos del alumno con id = $id con el formato adecuado 
     * para asignarlos a la plantilla de la vista
     * 
     * @param int $idResponsable
     * @return array
     */
    private function _getActividades($idResponsable)
    {
        $actividades = $this->_model->getActividadesResponsable($this->filtrarInt($idResponsable));
        for ($i = 0; $i < count($actividades); $i++) {
            $actividades[$i]['row'] = $i + 1;
            if ($actividades[$i]['fecha_inicio'] != '0000-00-00') {
                $actividades[$i]['fechas'] = FechaHora::construirExprFecha($actividades[$i]['fecha_inicio'], $actividades[$i]['fecha_fin']);
                $actividades[$i]['fechas_largo'] = FechaHora::construirExprFecha($actividades[$i]['fecha_inicio'], $actividades[$i]['fecha_fin'], true);
                if ($actividades[$i]['hora_inicio'] != '00:00:00') {
                    $actividades[$i]['horas'] = 'De ' . FechaHora::HoraCorta($actividades[$i]['hora_inicio'])
                            . ' a ' . FechaHora::HoraCorta($actividades[$i]['hora_fin']);
                    $actividades[$i]['pendiente'] = false;
                } else {
                    $actividades[$i]['horas'] = 'A confirmar';
                    $actividades[$i]['pendiente'] = true;
                }
            } else {
                $actividades[$i]['fechas'] = $actividades[$i]['fechas_largo'] = $actividades[$i]['horas'] = 'A confirmar';
                $actividades[$i]['pendiente'] = true;
            }
            $actividades[$i]['nombre_elipsis'] = ellipsis($actividades[$i]['nombre'], 40);
        }
        return $actividades;
    }

    public function buscar()
    {
        parent::_buscar_();
    }

    public function _formato($dato)
    {
        $dato['nombre'] = $this->getNombreApellido($dato);

        return $dato;
    }

    public function auto($cantidad = 1)
    {
        for ($i = 0; $i < $cantidad; $i++) {
            $this->_model->auto();
        }
        $this->_view->renderizar_template('index', $this->_modulo);
    }

}
