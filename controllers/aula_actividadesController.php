<?php

class aula_actividadesController extends Controller {

    protected $_table = 'aula_actividades';
    protected $_modulo = 'aula_actividades';

    CONST TBL_USUARIOS = 'aula_usuarios';
    const VAR_PAGE_NAME = 'pagina_aula_actividades';

    private $_titulo;

    CONST AFORO = 16;

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel($this->_modulo);

        $this->_titulo = 'AULA INNOVA | ';
    }

    /*
     * Listado de usuarios
     */

    public function index($pag = 1)
    {
//        Session::accesoEstricto(array('aula_innova', 'especial'));
        $this->_definirAccesoAula_();
        $pagina = $this->filtrar_pagina($pag);
        Session::set(self::VAR_PAGE_NAME, $pagina);

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
            Session::set('mensaje', $this->_mensaje);
        }
        $this->asignar_mensajes();

        $this->_view->setJs(array('confirmarBorrar', 'datepicker'));

        $this->_titulo.= 'Actividades';

        $actividades = $this->_model->getAllActividades();
        for ($i = 0; $i < count($actividades); $i++) {
            $actividades[$i]['row'] = $i + 1;
            $actividades[$i] = $this->_formato($actividades[$i]);
        }

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('titulo', $this->_titulo);

        $this->_view->assign('actividades', $paginador->paginar($actividades, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('controlador', $this->_modulo);


        $this->_view->renderizar_template('index', $this->_modulo);
    }

    public function nuevo()
    {
        $this->_definirAccesoAula_();

        $this->_titulo.= 'Nueva actividad';
        $this->_view->assign('titulo', $this->_titulo);
        $tipos = $this->pasarTablaACombo('aula_tipo_actividad');

        $this->_view->assign('tipos', $tipos);

//        $this->_view->assign('horas_curso_defecto',DEFAULT_HORAS_CURSO);
        $this->_view->setJs(array('ajax', 'datepicker', 'initTinyMCE'));

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('nuevo')) {
                $this->_view->renderizar_template('nuevo', $this->_modulo);
                exit;
            }
//Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                ':id_tipo' => $this->getInt('id_tipo'),
//                ':id_profesor' => $this->getInt('id_profesor'),
                ':nombre' => $this->getAlphaNum('nombre'),
                ':descripcion' => $this->getPostParam('descripcion'),
                ':fecha_inicio' => $this->getPostParam('fecha_inicio'),
                ':fecha_fin' => $this->getPostParam('fecha_fin'),
                ':hora_inicio' => $this->getPostParam('hora_inicio'),
                ':hora_fin' => $this->getPostParam('hora_fin')
                    )
            );

//Comprobar si se ha escrito el registro en la tabla
            if (!$this->_model->getLastID()) {
                Session::set('error', 'Error al registrar la actividad');

                $this->redireccionar($this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);

            $id = $this->_model->getLastID();
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong><a href="' . $url . '">'
                    . $this->_crearNombreActividad($id) . '</strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    public function editar($idActividad)
    {
        $this->_definirAccesoAula_();

        if (!$this->filtrarInt($idActividad)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idActividad))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $idActividad);
            exit;
        }

        $this->_view->setJS(array('initTinyMCE'));
        $this->_titulo.= 'Editar actividad';
        $this->_view->assign('titulo', $this->_titulo);

        $tipos = $this->pasarTablaACombo('aula_tipo_actividad');
        $responsables = $this->pasarTablaACombo('aula_responsables');


        $this->_view->assign('tipos', $tipos);
        $this->_view->assign('responsables', $responsables);

        if ($this->getInt('guardar') == 1) {
//            vardump($_POST);

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':id_tipo' => $this->getInt('id_tipo'),
                ':id_responsable' => $this->getInt('id_responsable'),
                ':nombre' => $this->getAlphaNum('nombre'),
                ':descripcion' => $this->getTexto('descripcion'),
                ':fecha_inicio' => $this->getPostParam('fecha_inicio'),
                ':fecha_fin' => $this->getPostParam('fecha_fin'),
                ':hora_inicio' => $this->getPostParam('hora_inicio'),
                ':hora_fin' => $this->getPostParam('hora_fin'),
            );

            $this->_model->editarRegistro($this->_table, $idActividad, $campos);

//            if ($idActividad == Session::getId()) {
//                Session::set('nombre', $this->getPostParam('nombre'));
//            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $idActividad;


            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">'
                    . $this->getAlphaNum('nombre') . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina_actividades'));
        }

        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($idActividad)));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Ver ficha de actividad (y subtabla con usuarios)
     * 
     * @param int $idActividad
     * @param int $pagina
     */
    public function ver($idActividad, $pagina = 1)
    {
        Session::set('pagina_actividades', $pagina);
        $this->_titulo.= 'Actividad';
        $this->_view->assign('titulo', $this->_titulo);

        $this->_definirAccesoAula_();
        if (!$this->filtrarInt($idActividad)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idActividad))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $this->filtrarInt($idActividad));
            exit;
        }

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }

        $this->asignar_mensajes();

        $this->_view->setJs(array('confirmarBorrar', 'editarMatricula', 'obtenerCertificado'));

        if (!$this->_model->getById($this->_table, $idActividad)) {
            $this->saltar_error(804, __METHOD__, $idActividad); //probablemente falta profesor
        }

        $actividad = $this->_formato($this->_model->getById($this->_table, $idActividad));
//        vardumpy($actividad);

        $usuarios = $this->_getUsuarios($idActividad);
//        vardumpy($usuarios);
        $this->_view->assign('usuarios', $usuarios);

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('titulo', "Ficha del curso");
        $this->_view->assign('controlador', $this->_modulo);
        $this->_view->assign('datos', $actividad);
        $this->_view->assign('usuarios', $paginador->paginar($usuarios, $pagina, 10));

        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $idActividad));
        $paginas = $paginador->get_paginacion();

        $this->_view->assign('paginas', ($paginas['total'] > 1));
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));
        $this->_view->assign('ref', $_SERVER['HTTP_REFERER']);
        $this->_view->assign('pagina_listado', Session::get('pagina_actividades'));

        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    public function eliminar($id, $controlador = false, $acceso = Session::ROLE_AULA_INNOVA, $pagina = self::VAR_PAGE_NAME)
    {

        $actividad = $this->_model->getById($this->_table, $id);
        $nombreActividad = $actividad['nombre'];

        Session::set('nombre_borrado', capitalizar($nombreActividad));
        parent::eliminar($id, $this->_modulo, $acceso, $pagina);
    }

    public function inscribir($idActividad)
    {
        $this->_definirAccesoAula_();

        if (!$this->filtrarInt($idActividad)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idActividad))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $idActividad);
            exit;
        }

        $actividad = $this->_formato($this->_model->getById('aula_actividades', $idActividad));


        $this->_titulo.= 'Inscribir | <small>' . $actividad['nombre'] . ' (' . $actividad['fechas'] . ')</small>';
        $this->_view->assign('titulo', $this->_titulo);
        $this->asignar_mensajes();

//        $this->_view->assign('curso', $this->_crearNombreCurso($idFichaCurso));

        $usuarios = $this->_getUsuarios($idActividad);

        $this->_view->assign('usuarios', $usuarios);

        $this->_view->assign('controlador', $this->_modulo);

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);
            $dni = $this->getPostParam('dni');

            if (!DEBUG) {
                if (!comprobar_letra_nif($this->getAlphaNum('dni'))) {
                    $error = '<strong>DNI/NIF no válido</strong><br/>';
                    $this->_view->assign('error', $error);

                    $this->_view->assign('dni', $this->getPostParam('dni'));
                    $this->_view->renderizar_template('inscribir', $this->_modulo);

                    exit;
                }
            }

            $this->_inscribirOCrearUsuario($idActividad, $dni);
            exit;
        }

        $this->_view->renderizar_template('inscribir', $this->_modulo);
    }

    public function _formato($dato)
    {
        if ($dato['fecha_inicio'] != '0000-00-00') {
            $dato['fechas'] = FechaHora::construirExprFecha($dato['fecha_inicio'], $dato['fecha_fin']);
            $dato['fechas_largo'] = FechaHora::construirExprFecha($dato['fecha_inicio'], $dato['fecha_fin'], true);
            if ($dato['hora_inicio'] != '00:00:00') {
                $dato['horas'] = 'De ' . FechaHora::HoraCorta($dato['hora_inicio'])
                        . ' a ' . FechaHora::HoraCorta($dato['hora_fin']);
                $dato['pendiente'] = false;
            } else {
                $dato['horas'] = 'A confirmar';
                $dato['pendiente'] = true;
            }
        } else {
            $dato['fechas'] = $dato['fechas_largo'] = $dato['horas'] = 'A confirmar';
            $dato['pendiente'] = true;
        }
        $dato['nombre_elipsis'] = ellipsis($dato['nombre'], 40);
        $dato['responsable'] = $this->getNombreApellido(
                $this->_model->getById('aula_responsables', $dato['id_responsable']));

        return $dato;
    }

    private function _comprobarDatos()
    {
        $err = null;
        $horaInicio = $this->getPostParam('hora_inicio');
        $horaFin = $this->getPostParam('hora_fin');

//Comprobaciones comunes
        if (!$this->getAlphaNum('nombre')) {
            $err = "Debe introducir un nombre para la actividad";
        } elseif (!$this->_model->existeRegistro('aula_tipo_actividad', array('id' => $this->getInt('id_tipo')))) {
            $err = "Debe seleccionar un tipo de actividad";
        } elseif ($this->getPostParam('fecha_fin') < $this->getPostParam('fecha_inicio')) {
            $err = 'La fecha de fin debe ser igual o posterior a la fecha de inicio';
        } elseif ($horaFin < $horaInicio) {
            $err = 'La hora de fin debe ser posterior a la hora de inicio';
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function _crearNombreActividad($idActividad)
    {
        $fichaCurso = $this->_model->getById($this->_table, $idActividad);

        $n = "(";
        $n .= $this->_model->getNombreActividad($idActividad) . ' - ';
        $n .= FechaHora::fechaCorta($fichaCurso['fecha_inicio']);
        $n .= ")";

        return $n;
    }

    private function _getUsuarios($idActividad)
    {

        $id = $this->filtrarInt($idActividad);

        $usuarios = $this->_model->getUsuariosActividad($id);

        for ($index = 0; $index < count($usuarios); $index++) {
            $usuarios[$index]['row'] = $index + 1;
            $usuarios[$index]['dni'] = strtoupper($usuarios[$index]['dni']);
            $usuarios[$index]['nombre'] = capitalizar($usuarios[$index]['apellidos'] . ', ' . $usuarios[$index]['nombre']);
            $usuarios[$index]['telefono'] = formato_telefono(($usuarios[$index]['telefono']));
        }

//        vardumpy($usuarios);
        return $usuarios;
    }

    private function _inscribirOCrearUsuario($idActividad, $dni)
    {
        $usuario = $this->_model->getUsuarioByDNI($dni);
        if ($usuario) {
//Alumno ya existe
            $this->inscribirUsuario($idActividad, $usuario['id']);
            exit;
        } else {//Alumno nuevo
            $mensaje = "<strong>Usuario nuevo</strong><hr/><div class='text-center'>Introduzca los datos</div>";
            $this->_view->assign('mensaje', $mensaje);
            $this->crearUsuario($idActividad, $dni);
        }
    }

    public function inscribirUsuario($idActividad, $idUsuario)
    {

        $this->_definirAccesoAula_();

        $usuario = $this->_model->getById('aula_usuarios', $idUsuario);
        $actividad = $this->_model->getNameById('aula_actividades', $idActividad);
//        vardump($usuario);
//        vardump($actividad);
//        $this->_tituloPagina($idFichaCurso);
//        $this->_model->insertarRegistro('ficha_alumnos', $campos);

        if ($this->_model->inscribirUsuarioEnActividad($idActividad, $idUsuario)) {
//            puty(__METHOD__);

            $urlUsuario = BASE_URL . 'aula_usuarios' . '/ver/' . $idUsuario;
            $urlActividad = BASE_URL . $this->_modulo . '/ver/' . $idActividad;
            $mensaje = '<div class="text-center">Se ha inscrito a '
                    . '<a href="' . $urlUsuario . '">'
                    . '<strong>' . capitalizar($usuario['apellidos'] . ', ' . $usuario['nombre']) . '</strong>'
                    . '</a> en la actividad <br/>'
                    . '<a href="' . $urlActividad . '"><em>' . $actividad . '</em></a>'
                    . '</div>';
            Session::set('mensaje', $mensaje);
            $this->_mensaje = $mensaje;
        } else {
//            puty('err');
            $error = "<strong>{$this->getNombreApellido($usuario)}</strong>"
                    . " con DNI <strong>{$usuario['dni']}</strong> "
                    . "ya est&aacute; inscrito en esta actividad";
            Session::set('error', $error);
        }
        $this->redireccionar($this->_modulo . '/inscribir/' . $idActividad);
    }

    public function crearUsuario($idActividad, $dni)
    {

        $actividad = $this->_formato($this->_model->getById('aula_actividades', $idActividad));

        $this->_view->setJs(array('datepicker'));

        $this->_view->assign('id_actividad', $idActividad);
        $this->_view->assign('titulo', $this->_titulo);

        $datos['dni'] = $dni;
        $this->_view->assign('datos', $datos);

        if ($this->getInt('guardar_nuevo') == 1) {
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatosUsuario()) {

                $this->_view->renderizar_template('nuevo_usuario', $this->_modulo);
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
                ':fecha_creacion' => date('Y-m-d'),
                ':creador' => Session::getId()
            );
//            puty('insertar');
            $this->_model->insertarRegistro(self::TBL_USUARIOS, $campos);

//            $url = BASE_URL . $this->_modulo . '/ver/' . $id;
//            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">' .
//                    capitalizar($this->getPostParam('apellidos')) . ', ' . capitalizar($this->getPostParam('nombre')) .
//                    '</a></strong> ha sido modificado');
            $idAlumno = $this->_model->getLastID();
            $this->redireccionar($this->_modulo . '/inscribirUsuario/' . $idActividad . '/' . $idAlumno);
            puty(__METHOD__);
        }

        $this->_view->renderizar_template('nuevo_usuario', $this->_modulo);
        put(__METHOD__);
        vardump($_POST);
    }

//    private function _definirAcceso()
//    {
//
//        Session::accesoEstricto(array('aula_innova', 'especial'));
//    }

    public function borrarInscripcion($idActividad, $idUsuario)
    {
        $this->_definirAccesoAula_();

        $idABorrar = $this->_model->getIdABorrar($idActividad, $idUsuario);
        $usuario = $this->_model->getById('aula_usuarios', $idUsuario);
        $nombreUsuario = $this->getNombreApellido($usuario);

        Session::set('nombre_borrado', $nombreUsuario);
        $reg_borrado = Session::get('nombre_borrado');

        $pagina = Session::get('pagina'); //página del listado que se visualiza

        if (!$this->filtrarInt($idABorrar)) {
            $this->redireccionar($this->_modulo);
            exit;
        }

        $url = BASE_URL . 'aula_usuarios' . '/ver/' . $idUsuario;

        $table = 'aula_usuarios_actividades';
        $error = "<div class='text-center'>Error al borrar ";


        if (!$this->_model->getById($table, ($this->filtrarInt($idABorrar)))) {
            $error .= "no se encuentra el registro.";
            $error .= "</div>";
            Session::set('error', $error);
            Session::destroy('nombre_borrado');
            $this->redireccionar($this->_modulo . '/ver/' . $idActividad);
            exit;
        }
        if (!$this->_model->eliminarRegistro($table, ($this->filtrarInt($idABorrar)))) {
            Session::destroy('nombre_borrado');
            if (!empty($reg_borrado)) {
                $error .= " el registro correspondiente a <a href='" . $url . "'><strong>" . $reg_borrado . "</strong></a>";
            }
            $error .= "</div>";
            $error .= "<div class='text-center'>Es posible que haya registros en otras tablas que dependan de este.</div>";
            Session::set('error', $error);
            $this->redireccionar($this->_modulo . '/ver/' . $idActividad);
            exit;
        } else {
            $this->redireccionar($this->_modulo . '/ver/' . $idActividad);
        }
    }

    public function editarInscripcion($idActividad, $idUsuario)
    {
        $this->_definirAccesoAula_();

        $titulo = $this->_titulo . 'Editar Datos de Inscripcion';
        $this->_view->setJs(array('initTinyMCE'));

        $datos_inscripcion = $this->_model->getDatosInscripcion($idActividad, $idUsuario);
        $datos_inscripcion['usuario'] = $this->getNombreApellido($datos_inscripcion);
        $datos_inscripcion = $this->_formato($datos_inscripcion);

        $this->_view->assign('titulo', $titulo);
        $this->_view->assign('datos', $datos_inscripcion);

        if ($this->getInt('guardar') == 1) {

            $datos_inscripcion['notas'] = $this->getPostParam('notas');
            $datos_inscripcion['asistencia'] = $this->getPostParam('asistencia');

            $this->_view->assign('datos', $datos_inscripcion);

            if ($datos_inscripcion['asistencia'] == 'on') {
                $datos_inscripcion['asistencia'] = 1;
            } else {
                $datos_inscripcion['asistencia'] = 0;
            }

            $campos = array(
                ':notas' => $datos_inscripcion['notas'],
                ':asistencia' => $datos_inscripcion['asistencia']
            );

            $table = 'aula_usuarios_actividades';
            $this->_model->editarRegistro($table, $datos_inscripcion['id'], $campos);

            $url = BASE_URL . $this->_modulo . '/ver/' . $idActividad . '/' . $idUsuario;

            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">'
                    . $datos_inscripcion['usuario'] . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/ver/' . $datos_inscripcion['id_actividad']);
        }

        $this->_view->renderizar_template('editar_inscripcion', $this->_modulo);
    }

    private function _comprobarDatosUsuario()
    {
        $err = null;

        if ($this->_model->existeRegistro(
                        self::TBL_USUARIOS, array('dni' => $this->getAlphaNum('dni'))
                )) {
            $err = 'Ya existe un alumno con este dni/nie';
        }
        if (!$err) {
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

        if ($err) {
            $this->_view->assign('error', $err);
            Session::set('error', $err);
            return false;
        } else {
            return true;
        }
    }

}
