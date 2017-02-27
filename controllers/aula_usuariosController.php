<?php

class aula_usuariosController extends Controller {

    const VAR_PAGE_NAME = 'pagina_aula_usuarios';

    protected $_table = 'aula_usuarios';
    protected $_modulo = 'aula_usuarios';
    private $_titulo;

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('aula_usuarios');
        $this->_titulo = 'AULA INNOVA | ';
    }

    /**
     * Listado de alumnos
     * 
     * @param int $pag Página del listado a mostrar
     */
    public function index($pag = 1)
    {
        Session::accesoEstricto(array('aula_innova', 'especial'));
        if (Session::get('sql')) {
            $this->resultados_busqueda(Session::get('pagina_usuarios'));
            exit;
        }
        $pagina = $this->filtrar_pagina($pag);
        Session::set(self::VAR_PAGE_NAME, $pagina);

        $this->_view->setJs(array('confirmarBorrar'));

        $this->_titulo .='Usuarios';

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
            Session::set('mensaje', $this->_mensaje);
        }

        $this->asignar_mensajes();

        //traer datos de la tabla

        $datos = $this->_model->getUsuariosAula();
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
     * Código del botón buscar.
     * Lee el dato de $_POST, realiza la búsqueda y pasa la sentencia SQL a resultados_busqueda()
     */
    public function buscar()
    {
        $buscar = $this->getPostParam('busqueda');
        Session::set('buscar', $buscar);
        //Determinar si es DNI o nombre
        if (!is_null($buscar)) {
            //Buscar
            if (preg_match('/\d/', $buscar)) {//Es número, buscar por dni o teléfono
                $campos = array('dni' => $buscar, 'telefono' => $buscar);
                Session::set('sql', $this->_model->searchAll($this->_table, $campos, 1));
            } else {//Buscar por nombre y apellido
                $campos = array('nombre' => $buscar, 'apellidos' => $buscar);
                Session::set('sql', $this->_resultados_busqueda = $this->_model->searchAll($this->_table, $campos, 1));
            }
        }
        //Devolver resultados
        $this->resultados_busqueda();
    }

    /**
     * Lista los resultados de la búsqueda
     * 
     * @param int $pagina página del listado
     */
    public function resultados_busqueda($pagina = 1)
    {

        Session::accesoEstricto(array('aula_innova', 'especial'));
        $pagina = $this->filtrar_pagina($pagina);

        $datos = $this->_model->getSQL(Session::get('sql'));
        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index]['row'] = $index + 1;
            $datos[$index] = $this->_formato($datos[$index]);
        }

        $this->asignar_mensajes();
        $this->_view->setJs(array('confirmarBorrar'));

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);

        Session::set('pagina', $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/resultados_busqueda'));
        $this->_view->assign('titulo', 'Resultado de la búsqueda: <small>' . Session::get('buscar') . '</small>');
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('es_busqueda', TRUE);
        $this->_view->assign('controlador', $this->_modulo);

        if (count($datos) == 0) {
            Session::destroy('sql');
        }


        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Ver ficha de usuario (y subtabla con actividades)
     * 
     * @param int $idUsuario
     * @param int $pagina
     */
    public function ver($idUsuario, $pagina = 1)
    {
        Session::accesoEstricto(array('aula_innova', 'especial'));
        $ref = null;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $ref = $_SERVER['HTTP_REFERER'];
        }
        if (!$this->filtrarInt($idUsuario)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idUsuario))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $this->filtrarInt($idUsuario));
            exit;
        }
        $this->_view->setJs(array('confirmarBorrar', 'obtenerCertificado'));

        $this->_titulo .='Ficha del usuario';
//        $this->asignar_mensajes();

        $datos = $this->_formato($this->_model->getById($this->_table, $this->filtrarInt($idUsuario)));
//        $old_datos = $datos;
//        $datos = $this->formato_datos($datos);
//        $datos['fechaNac'] = FechaHora::fechaATexto($old_datos['fechaNac'], TRUE);

        $actividades = $this->_getActividades($idUsuario);
//        vardumpy($actividades);
//        vardump($datos);
//        vardumpy($cursos);

        $this->getLibrary('paginador');
        $paginador = new Paginador();
        $paginador_actividades = null;
        if ($actividades) {
            $paginador_actividades = $paginador->paginar($actividades, $pagina, 10);
            $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $idUsuario));
            $p = $paginador->get_paginacion();
            $this->_view->assign('paginas', ($p['total'] > 1));
        }

        $this->_view->assign('titulo', $this->_titulo);
        $this->_view->assign('controlador', $this->_modulo);
//        $this->_view->assign('controlador', 'alumno');
        $this->_view->assign('datos', $datos);
        $this->_view->assign('actividades', $paginador_actividades);
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));
        $this->_view->assign('ref', $ref);

        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    /**
     * Editar alumno con id = $id
     * 
     * @param int $id
     */
    public function editar($id)
    {
        Session::accesoEstricto(array('aula_innova', 'especial'));
//        Session::set('editando_id', $id);
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $id);
            exit;
        }

        $this->_titulo .='Editar usuario';

        $this->_view->assign('titulo', $this->_titulo);
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->setJs(array('datepicker'));

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->comprobar_datos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':dni' => $this->getPostParam('dni'),
                ':nombre' => capitalizar($this->getPostParam('nombre')),
                ':apellidos' => capitalizar($this->getPostParam('apellidos')),
                ':fecha_nacimiento' => $this->getPostParam('fechaNac'),
                ':telefono' => $this->getPostParam('telefono'),
                ':sexo' => substr($this->getPostParam('sexo'), 0, 1),
                ':email' => $this->getPostParam('email'),
                ':modificador' => Session::getId(),
                ':fecha_modificacion' => FechaHora::Hoy()
            );

            if (!$this->_model->editarRegistro($this->_table, $id, $campos)) {
                $err = "Error al editar registro, probablemente el NIF ya exista en la BD";
                $this->_view->assign('error', $err);
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            } else {

                if ($id == Session::getId()) {
                    Session::set('nombre', $this->getPostParam('nombre'));
                }
                $url = BASE_URL . $this->_modulo . '/ver/' . $id;

                $this->_mensaje = 'El registro correspondiente a <strong><a href="' . $url . '">'
                        . capitalizar($this->getPostParam('apellidos') . ', ' . $this->getPostParam('nombre'))
                        . '</a></strong> ha sido modificado';
                Session::set('mensaje', $this->_mensaje);
            }
//            $this->setMensaje($mensaje);

            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($id)));


        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Eliminar alumno con id = $id
     * 
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = Session::ROLE_AULA_INNOVA, $pagina = self::VAR_PAGE_NAME)
    {
//        Session::acceso('especial');
        $alumno = $this->_model->getById($this->_table, $id);
        $nombre = $alumno['apellidos'];
        $nombre .= ', ' . $alumno['nombre'];

        Session::set('nombre_borrado', capitalizar($nombre));
        parent::eliminar($id, $this->_modulo, $acceso, $pagina);
    }

    /**
     * Da formato a los datos antes de enviarlos a la plantilla de la vista
     * 
     * @param array $datos recordset con los datos a mostrar
     * @return array
     */
    private function _formato($datos)
    {
        $datos['dni'] = strtoupper($datos['dni']);
        $datos['nombre'] = $this->getNombreApellido($datos);
        $datos['telefono'] = formato_telefono(($datos['telefono']));

        $datos['fecha_nacimiento'] = FechaHora::fechaATexto($datos['fecha_nacimiento']);
        $fecha = new DateTime($datos['fecha_creacion']);
        $datos['fecha_alta'] = FechaHora::fechaATexto($fecha->format('Y-m-d'));

        return $datos;
    }

    /**
     * Devuelve los cursos del alumno con id = $id con el formato adecuado 
     * para asignarlos a la plantilla de la vista
     * 
     * @param int $idUsuario
     * @return array
     */
    private function _getActividades($idUsuario)
    {
        $actividades = $this->_model->getActividadesUsuario($this->filtrarInt($idUsuario));
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
        if (strtoupper(substr($this->getAlphaNum('dni'), 0, 1)) == 'N') {// es niño
            //calcular numero niño
            $_POST['dni'] = $this->_model->GetDniNino();
        } elseif (!comprobar_letra_nif($this->getAlphaNum('dni'))) {
            $err = 'NIF/NIE incorrecto';
        }

        if (!$err) {
            if (!$this->getSql('nombre') || !$this->getSql('apellidos')) {
                $err = 'Debe introducir el nombre y los apellidos del usuario';
//            } elseif (!datecheck($this->getPostParam('fecha_nacimiento'))) {
//                $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fechaNac');
            } elseif (!array_key_exists('sexo', $_POST)) {
                $err = "Seleccione Hombre o Mujer";
            }
        }

        //comprobaciones para cada caso
        if (is_null($err)) {
            if ($accion === 'editar') {
                $err = $this->comprobar_datos_editar();
            } elseif ($accion === 'nuevo') {
                $err = $this->comprobar_datos_nuevo();
            }
        }

        if ($err) {
//            puty($err);
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function comprobar_datos_nuevo()
    {
        $err = null;

        if (!$this->_model->existeRegistro(
                        $this->_table, array('dni' => $this->getAlphaNum('dni'))
                )) {
            $err = 'Ya existe un alumno con este dni/nie';
        }

        return $err;
    }

    public function comprobar_datos_editar()
    {
        $err = null;


        return $err;
    }

    /**
     * Código para el botón "ver todo" (en búsqueda)
     */
    public function ver_todo()
    {
        Session::destroy('sql');
        Session::destroy('buscar');
        $this->index(Session::get('pagina'));
    }

    /**
     * Crear usuarios automaticamente (hay que llamrala desde la barra de direcciones)
     * @param type $cantidad
     */
    public function auto($cantidad = 1)
    {
        for ($i = 0; $i < $cantidad; $i++) {
            $this->_model->auto();
        }
    }

}
