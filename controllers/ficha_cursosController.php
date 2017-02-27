<?php

class ficha_cursosController extends Controller {

    protected $_table = 'ficha_cursos';
    protected $_modulo = 'ficha_cursos';
    private $_pagina;
    private $_filtroTemplate;
    private $_filtro = array();

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('ficha_cursos');
        $this->_filtroTemplate = ROOT . 'views' . DS . 'ficha_cursos' . DS . 'filtro_listado.tpl';
    }

    /*
     * 
     */

    public function index($pag = 1, $accion = "")
    {
        Session::acceso('usuario');
        $this->_pagina = $this->filtrar_pagina($pag);
        Session::set('pagina_ficha_cursos', $this->_pagina);

//Aplicar filtro
        $filtro = $this->_aplicarFiltro();
        $s = Session::get('filtro');
        $filtrado = !empty($s);
        $titulo = $this->_crearTitulo($filtro);

        $this->_view->setJs(array('confirmarBorrar', 'datepicker', 'confirmar_imprimir_hojas_cursos'));

        $cursos = $this->pasarTablaACombo('cursos', "Todos");

        $centros = $this->_crearComboCentros();

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
            Session::set('mensaje', $this->_mensaje);
        }
        $this->asignar_mensajes();

//        vardump($filtro);
        $this->_view->assign('filtro', $filtro);
        $ficha_cursos = $this->_model->getDatosListado($filtro);
//        vardumpy($alumnos);
        for ($index = 0; $index < count($ficha_cursos); $index++) {
            $ficha_cursos[$index]['row'] = $index + 1;
            $ficha_cursos[$index] = $this->_formatoDatos($ficha_cursos[$index]);
        }


        $this->_view->assign('cursos', $cursos);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('_filtro', $this->_filtroTemplate);

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $this->_pagina);
        Session::set('pagina', $this->_pagina);

        $this->_view->assign('datos', $paginador->paginar($ficha_cursos, $this->_pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', $titulo);
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($ficha_cursos));
        $this->_view->assign('controlador', $this->_modulo);
        $this->_view->assign('filtrado', $filtrado);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Ver ficha de curso (y subtabla con alumnos)
     * 
     * @param int $id
     * @param int $pagina
     */
    public function ver($id, $pagina = 1)
    {

//        puty( $_SERVER['HTTP_REFERER']);
        Session::acceso('usuario');
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $this->filtrarInt($id));
            exit;
        }


        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }

        $this->asignar_mensajes();

        $this->_view->setJs(array('confirmarBorrar', 'editarMatricula', 'obtenerCertificado'));

        if (!$this->_model->getCursoById($id)) {
            $this->saltar_error(804, __METHOD__, $id); //probablemente falta profesor
        }
        $cursos = $this->_formatoDatos($this->_model->getCursoById($id), 'ver');
        $profesor = $this->getNombreApellido($this->_model->getProfesorByCursoId($id));

        $alumnos = $this->getAlumnos($id);

        $matriculados = count($alumnos);
        $plazasLibres = $cursos['aforo'] - $matriculados;

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        if ($plazasLibres < 1) {
            $this->_error = "No quedan  plazas libres en este curso";
            $this->asignar_mensajes();
        }

        $this->_view->assign('titulo', "Ficha del curso");
        $this->_view->assign('controlador', 'ficha_cursos');
        $this->_view->assign('datos', $cursos);
        $this->_view->assign('alumnos', $paginador->paginar($alumnos, $pagina, 10));
        $this->_view->assign('profesor', $profesor);
        $this->_view->assign('matriculados', $matriculados);
        $this->_view->assign('plazas_libres', $plazasLibres);
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $id));

        $paginas = $paginador->get_paginacion();
//        vardump($paginas);
        $this->_view->assign('paginas', ($paginas['total'] > 1));
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));
        $this->_view->assign('ref', $_SERVER['HTTP_REFERER']);
        $this->_view->assign('pagina_listado', Session::get('pagina_ficha_cursos'));

        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    /**
     * Crear curso
     */
    public function nuevo()
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Nuevo curso');
        $cursos = $this->pasarTablaACombo('cursos');
        $centros = $this->pasarTablaACombo('centros');
        $profesores = $this->_profActivos($this->_model->getAll('usuarios'));

        $this->_view->assign('cursos', $cursos);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('profesores', $profesores);

        $this->_view->assign('horas_curso_defecto',DEFAULT_HORAS_CURSO);
        $this->_view->setJs(array('ajax', 'datepicker', 'form_nuevo'));

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('nuevo')) {
                $this->_view->renderizar_template('nuevo', $this->_modulo);
                exit;
            }
//Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(':id_curso' => $this->getInt('id_curso'),
                ':id_centro' => $this->getInt('id_centro'), ':id_profesor' => $this->getInt('id_profesor'),
                ':fecha_inicio' => $this->getPostParam('fecha_inicio'), ':fecha_fin' => $this->getPostParam('fecha_fin'),
                ':hora_inicio' => $this->getPostParam('hora_inicio'), ':hora_fin' => $this->getPostParam('hora_fin'),
                ':horas_totales' => $this->getInt('horas_totales'), ':creador' => Session::getId()));

//Comprobar si se ha escrito el registro en la tabla
            $campos = array('id_curso' => $this->getInt('id_curso'),
                'id_centro' => $this->getInt('id_centro'), 'fecha_inicio' => $this->getPostParam('fecha_inicio'),
                'hora_inicio' => $this->getPostParam('hora_inicio'));

            if (!$this->_model->existeRegistro($this->_table, $campos)) {
                $this->_view->assign('_error', 'Error al registrar el curso');

                put('existe ' . $this->_modulo);
//$this->index();
                $this->_view->assign('_filtro', $this->_filtroTemplate);

                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);

            $id = $this->_model->getLastID();
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong><a href="' . $url . '">'
                    . $this->_crearNombreCurso($id) . '</strong>');

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    /**
     * Editar curso con id = $id
     * 
     * @param int $id
     */
    public function editar($id)
    {

        Session::acceso('especial');
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $id);
            exit;
        }

        $cursos = $this->pasarTablaACombo('cursos');
        $centros = $this->pasarTablaACombo('centros');
        $profesores = $this->pasarTablaACombo('usuarios');

        $this->_view->assign('titulo', "Editar curso");
        $this->_view->assign('cursos', $cursos);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('profesores', $profesores);

        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':id_curso' => $this->getInt('id_curso'),
                ':id_centro' => $this->getInt('id_centro'),
                ':id_profesor' => $this->getInt('id_profesor'),
                ':fecha_inicio' => $this->getPostParam('fecha_inicio'),
                ':fecha_fin' => $this->getPostParam('fecha_fin'),
                ':hora_inicio' => $this->getPostParam('hora_inicio'),
                ':hora_fin' => $this->getPostParam('hora_fin'),
                ':horas_totales' => $this->getInt('horas_totales'),
                ':modificador' => Session::getId(),
                ':fecha_modificacion' => date('Y-m-d H:i:s')
            );

            $this->_model->editarRegistro($this->_table, $id, $campos);
            if ($id == Session::getId()) {
                Session::set('nombre', $this->getPostParam('nombre'));
            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;


            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">'
                    . $this->_crearNombreCurso($id) . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

//        vardump($this->_model->getById(
//                        $this->_table, $this->filtrarInt($id)));
        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($id)));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Eliminar curso con id = $id
     * 
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {

        Session::acceso('especial');
        $nombre = $this->_crearNombreCurso($id);

        Session::set('nombre_borrado', capitalizar($nombre));
        parent::eliminar($id, $this->_modulo);
    }

    /**
     * Pedir dni para matricular alumno en curso $idFichaCurso
     * 
     * @param int $idFichaCurso
     */
    public function matricular($idFichaCurso)
    {

        Session::acceso('usuario');

        if (!$this->filtrarInt($idFichaCurso)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idFichaCurso))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $idFichaCurso);
            exit;
        }

//Si no hay plazas asignar error y volver a ficha del curso
        $curso = $this->_model->getCursoById($idFichaCurso);
        $aforo = $curso['aforo'];

        if (count($this->_model->getAlumnosCurso($idFichaCurso)) >= $aforo) {
//            $error = "<strong>Curso completo</strong><br/>No hay más plazas libres";
//            $this->_view->assign('error', $error);

            $this->ver($idFichaCurso);

            exit;
        }

        $this->_tituloPagina($idFichaCurso);

        $this->_view->assign('curso', $this->_crearNombreCurso($idFichaCurso));

        $alumnos = $this->getAlumnos($idFichaCurso);
        $plazasLibres = $aforo - count($alumnos);
        $this->_view->assign('alumnos', $alumnos);
        $this->_view->assign('plazas_libres', $plazasLibres);

        $this->_view->assign('controlador', $this->_modulo);

        if ($this->getInt('guardar') == 1) {
            $dni = $this->getPostParam('dni');

            if (strtoupper(substr($this->getAlphaNum('dni'), 0, 1)) == 'N') {// es niño
//calcular numero niño
                $dni = $this->_model->GetDniNino();
            } elseif (!comprobar_letra_nif($this->getAlphaNum('dni'))) {
                $error = '<strong>DNI/NIF no válido</strong><br/>';
                $this->_view->assign('error', $error);

                $this->_view->assign('dni', $this->getPostParam('dni'));
                $this->_view->renderizar_template('matricular', $this->_modulo);

                exit;
            }

            $this->matricularOCrearAlumno($idFichaCurso, $dni);
            exit;
        }

        $this->_view->renderizar_template('matricular', $this->_modulo);
    }

    /**
     * Dar de alta a alumno si es nuevo, pedir datos de matrícula si ya existe
     * 
     * @param type $idFichaCurso
     * @param type $dni
     */
    public function matricularOCrearAlumno($idFichaCurso, $dni)
    {
//        Session::acceso('usuario');
        $alumno = $this->_model->getAlumnoByDNI($dni);
        if ($alumno) {
//Alumno ya existe
            $this->matricularAlumno($idFichaCurso, $alumno['id']);
            exit;
        } else {
//Alumno nuevo
            $mensaje = "<strong>Alumno nuevo</strong><hr/><div class='text-center'>Introduzca los datos</div>";
            $this->_view->assign('mensaje', $mensaje);
            $this->crearAlumno($idFichaCurso, $dni);
        }
    }

    public function matricularAlumno($idFichaCurso, $idAlumno, $referrer = false)
    {
        define('ACCION_NUEVO', 'nuevo');
        define('ACCION_EDITAR', 'editar');

        Session::acceso('usuario');
        $this->_tituloPagina($idFichaCurso);

//Saber si es nueva matricula o edicion
        $campos = array(
            'id_alumno' => $idAlumno,
            'id_ficha_curso' => $idFichaCurso
        );

        if ($this->_model->existeRegistro('ficha_alumnos', $campos)) {
//editar Matrícula
//            put('editar');
            $accion = ACCION_EDITAR;

            $datosMatricula = $this->_model->getDatosMatricula($idAlumno, $idFichaCurso);
//            vardump($datosMatricula);
            $idFichaAlumno = $datosMatricula['id'];
            if (!$referrer) {
                $this->_view->assign('mensaje', "<strong>Editar matr&iacute;cula</strong><hr/><div class='text-center'>El alumno ya est&aacute; matriculado en este curso</div>");
            }
            $this->_view->assign('datos_matricula', $datosMatricula);

//            vardump($datosMatricula);
        } else {
//Nueva matrícula
//            put('nuevo');
            $accion = ACCION_NUEVO;
            $this->_view->assign('mensaje', "<strong>Nueva matr&iacute;cula</strong><hr/><div class='text-center'>Introduzca los datos</div>");
        }

        $municipios = $this->pasarTablaACombo('municipios');
        $ocupaciones = $this->pasarTablaACombo('ocupacion');
        $estudios = $this->pasarTablaACombo('niveles_estudios');

        $this->_view->assign('municipios', $municipios);
        $this->_view->assign('ocupaciones', $ocupaciones);
        $this->_view->assign('estudios', $estudios);

        $this->_view->assign('datos', $this->_formatoAlumno($this->_model->getById('alumnos', $idAlumno)));
        $this->_view->assign('id_ficha_curso', $idFichaCurso);
        $this->_view->assign('accion', $accion);

        if ($this->getPostParam('matricular') == 1) {
//            vardumpy($_POST);

            $this->_view->assign('datos', $_POST);
            $alumno = $this->_model->getById('alumnos', $idAlumno);

            $campos = array(
                ':id_alumno' => $alumno['id'],
                ':id_ficha_curso' => $idFichaCurso,
                ':id_ocupacion' => $this->getInt('id_ocupacion'),
                ':id_municipio' => $this->getInt('id_municipio'),
                ':id_nivel_estudios' => $this->getInt('id_estudios'),
                ':antiguedad_paro' => $this->getInt('paro'),
                ':codigo_postal' => $this->getInt('cp'),
                ':edad' => FechaHora::edad($alumno['fechaNac']),
                ':plaza_discapacitado' => $this->getInt($alumno['discapacidad']),
                ':creador' => Session::getId()
            );

            if ($accion == ACCION_EDITAR) {
                $mensaje = '<div class="text-center">Se ha actualizado la matr&iacute;cula de ';
                $this->_model->editarRegistro('ficha_alumnos', $idFichaAlumno, $campos);
            } elseif ($accion == ACCION_NUEVO) {
                $mensaje = '<div class="text-center">Se ha matriculado a ';
                $this->_model->insertarRegistro('ficha_alumnos', $campos);
            }

            $mensaje .= '<strong>' . capitalizar($alumno['apellidos'] . ', ' . $alumno['nombre']) . '</strong>'
                    . ' en el curso '
                    . '<br/><em>' . $this->_crearNombreCurso($idFichaCurso) . '</em>'
                    . '</div>';
            Session::set('_mensaje', $mensaje);
            $this->redireccionar($this->_modulo . '/ver/' . $idFichaCurso);
        }

        $this->_view->renderizar_template('alumno_existe', 'alumno');
    }

    private function _formatoDatos($cursos, $accion = "index")
    {
//        vardump($cursos);
        $cursos['hora'] = substr($cursos['hora'], 0, 5);
        if ($accion == "ver") {
            $cursos['fecha'] = FechaHora::construirExprFecha($cursos['fecha'], $cursos['fecha_fin'], true,true);
            $cursos['fecha_fin'] = FechaHora::fechaATexto($cursos['fecha_fin']);
            $cursos['hora_fin'] = substr($cursos['hora_fin'], 0, 5);
        } else {
            $cursos['fecha'] = FechaHora::fechaCorta($cursos['fecha'], 2);
        }
        return $cursos;
    }

    private function _comprobarDatos($accion)
    {
        $err = null;
        $horaInicio = $this->getPostParam('hora_inicio');
        $horaFin = $this->getPostParam('hora_fin');

//Comprobaciones comunes
        if (!$this->_model->existeRegistro('cursos', array('id' => $this->getInt('id_curso')))) {
            $err = "Debe seleccionar un curso";
        } elseif (!$this->_model->existeRegistro('centros', array('id' => $this->getInt('id_centro')))) {
            $err = "Debe seleccionar un centro";
        } elseif (!datecheck($this->getPostParam('fecha_inicio'))) {
            $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fecha_inicio');
        } elseif (!datecheck($this->getPostParam('fecha_fin'))) {
            $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fecha_fin');
        } elseif ($this->getPostParam('fecha_fin') < $this->getPostParam('fecha_inicio')) {
            $err = 'La fecha de fin debe ser posterior a la fecha de inicio';
        } elseif (empty($horaInicio)) {
            $err = 'Debe introducir la hora de inicio';
        } elseif (empty($horaFin)) {
            $err = 'Debe introducir la hora de fin';
        } elseif ($horaFin < $horaInicio) {
            $err = 'La hora de fin debe ser posterior a la hora de inicio';
        }

//comprobaciones para cada caso
        if (is_null($err)) {
            if ($accion === 'editar') {
//                $err = $this->comprobar_datos_editar();
            } elseif ($accion === 'nuevo') {
                $err = $this->_comprobarDatosNuevo();
            }
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function _comprobarDatosNuevo()
    {
        $err = null;
        $campos = array('id_curso' => $this->getInt('id_curso'),
            'id_centro' => $this->getInt('id_centro'),
            'fecha_inicio' => $this->getPostParam('fecha_inicio'),
            'hora_inicio' => $this->getPostParam('hora_inicio'));

        if ($this->_model->existeRegistro($this->_table, $campos)) {
            $err = '<div class = "text-center"><em><strong>Ya existe un curso con estos datos</strong></em></div><hr/>';
            $err .= "<div class='col-md-10 pull-right'>";
            $err .= '<strong>Curso: </strong>' . $this->_model->getCurso($this->getInt('id_curso')) . '<br/>';
            $err .= '<strong>Centro: </strong>' . $this->_model->getCentro($this->getInt('id_centro')) . '<br/>';
            $err .= '<strong>Fecha inicio: </strong>' . $this->getPostParam('fecha_inicio') . '<br/>';
            $err .= '<strong>Hora inicio: </strong>' . $this->getPostParam('hora_inicio') . '<br/>';
            $err .= "</div>";
        }

        return $err;
    }

    private function _aplicarFiltro()
    {
        $old_filtro = array();
        $filtro = $_POST;
//        vardump($filtro);

        if (array_key_exists('limpiar', $_POST)) {//limpiar filtro
            $this->_pagina = 1;
            $filtro = array();
            Session::destroy('filtro');
        } else {
            $old_filtro = Session::get('filtro');

            if (empty($filtro)) {//filtro ha cambiado
//                put('usar filtro actual');
                $filtro = $old_filtro;
            } else {
                $this->_pagina = 1;
            }
        }
        Session::set('filtro', $filtro);

        if (!empty($filtro)) {
            return $filtro;
        } else {
            return array();
        }
    }

    private function _crearNombreCurso($idFichaCurso)
    {
        $fichaCurso = $this->_model->getById($this->_table, $idFichaCurso);
        $n = "(";
        $n .= FechaHora::fechaCorta($fichaCurso['fecha_inicio']) . ' - ';
        $n .= $this->_model->getNombreCurso($idFichaCurso) . ' - ';
        $n .= $this->_model->getNombreCentro($idFichaCurso);
        $n .= ")";
        return $n;
    }

    /**
     * Devuelve los alumnos del curso con id = $id con el formato adecuado 
     * para asignarlos a la plantilla de la vista
     * 
     * @param int $cursoID
     * @return array
     */
    public function getAlumnos($cursoID)
    {
        $id = $this->filtrarInt($cursoID);
        $alumnos = $this->_model->getAlumnosCurso($id);
//        vardumpy($alumnos);
        for ($index = 0; $index < count($alumnos); $index++) {
            $alumnos[$index]['row'] = $index + 1;
            $alumnos[$index]['dni'] = strtoupper($alumnos[$index]['dni']);
            $alumnos[$index]['nombre'] = capitalizar($alumnos[$index]['apellidos'] . ', ' . $alumnos[$index]['nombre']);
            $alumnos[$index]['telefono'] = formato_telefono(($alumnos[$index]['telefono']));

            /*
             * 
              'id_municipio' => string '0' (length=1)
              'codigo_postal' => string '0' (length=1)
              'id_nivel_estudios' => string '0' (length=1)
              'id_ocupacion' => string '0' (length=1)
              'antiguedad_paro' => string '0' (length=1)
             */
            if ($this->hayDatosMatricula($alumnos[$index])) {
                $alumnos[$index]['matricula_completa'] = true;
            } else {
                $alumnos[$index]['matricula_completa'] = false;
            }
        }
//        vardumpy($alumnos);

        return $alumnos;
    }

    /**
     * 
     * Comprueba si los datos de matrícula están completados
     * 
     * @param array $alumno Datos del alumno a comprobar
     * 
     * @return boolean
     */
    private function hayDatosMatricula($alumno)
    {
        $codigoDesempleado = $this->_model->getCodigoDesempleado();
        $r = true;
        if ($alumno['id_municipio'] == 0) {
            $r = false;
        } elseif ($alumno['id_ocupacion'] == 0) {
            $r = false;
        } elseif ($alumno['id_nivel_estudios'] == 0) {
            $r = false;
        } elseif ($alumno['codigo_postal'] == 0) {
            $r = false;
        } elseif ($alumno['antiguedad_paro'] == 0) {
            if ($alumno['id_ocupacion'] == $codigoDesempleado) {
                $r = false;
            }
        }
        return $r;
    }

    /**
     * Da formato a los datos para mandar a la plantilla
     * 
     * @param array $datos
     * 
     * @return array
     */
    private function _formatoAlumno($datos)
    {
        $datos['dni'] = strtoupper($datos['dni']);
        $datos['nombre'] = capitalizar($datos['apellidos'] . ', ' . $datos['nombre']);
        $f = FechaHora::fechaATexto($datos['fechaNac'], true);
        $datos['fechaNac'] = $f ? strtolower($f) : 'NO CONSTA';
        $datos['telefono'] = formato_telefono(($datos['telefono']));
        $datos['fecha_alta'] = FechaHora::fechaATexto(substr($datos['fecha_alta'], 0, 10));
        return $datos;
    }

    /**
     * Devuelve array para colocar en combo
     * 
     * @param string $tabla Tabla de la que se leen los datos
     * @param string $primeraOpcion Opción para el primer valor del combo (devuelve valor nulo)
     * 
     * @return array
     */
//    private function _leerTabla($tabla, $primeraOpcion = '')
//    {
//        $r = $this->_model->getTabla($tabla);
//        array_unshift($r, array(
//            'id' => '0',
//            'nombre' => $primeraOpcion));
//        return $r;
//    }

    /**
     * Crea un alumno para posteriormente matricularlo
     * 
     * @param int $idFichaCurso
     * @param string $dni
     */
    public function crearAlumno($idFichaCurso, $dni)
    {

        $this->_tituloPagina($idFichaCurso);
        $this->_view->setJs(array('confirmarBorrar', 'datepicker'));

        $this->_view->assign('id_ficha_curso', $idFichaCurso);

        $datos['dni'] = $dni;
        $this->_view->assign('datos', $datos);

        if ($this->getInt('guardar_nuevo') == 1) {
//            vardumpy($_POST);

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatosAlumno('nuevo')) {

                $this->_view->renderizar_template('alumno_nuevo', $this->_modulo);
                exit;
            }

            $campos = array(
                ':dni' => $this->getInt('dni'),
                ':nombre' => capitalizar($this->getPostParam('nombre')),
                ':apellidos' => capitalizar($this->getPostParam('apellidos')),
                ':fechaNac' => $this->getPostParam('fechaNac'),
                ':telefono' => $this->getPostParam('telefono'),
                ':sexo' => substr($this->getPostParam('sexo'), 0, 1),
                ':discapacidad' => $this->getPostParam('discapacidad') ? 1 : 0,
                ':fecha_alta' => date('Y-m-d'),
                ':creador' => Session::getId()
            );
//            puty('insertar');
            $this->_model->insertarRegistro('alumnos', $campos);

//            $url = BASE_URL . $this->_modulo . '/ver/' . $id;
//            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">' .
//                    capitalizar($this->getPostParam('apellidos')) . ', ' . capitalizar($this->getPostParam('nombre')) .
//                    '</a></strong> ha sido modificado');
            $idAlumno = $this->_model->getLastID();
            $this->redireccionar($this->_modulo . '/matricularAlumno/' . $idFichaCurso . '/' . $idAlumno);
        }

        $this->_view->renderizar_template('alumno_nuevo', 'alumno');
//        put(__METHOD__);
    }

    private function _comprobarDatosAlumno($accion)
    {
        $err = null;
//        puty(__METHOD__);

        if ($this->_model->existeRegistro(
                        'alumnos', array('dni' => $this->getInt('dni'))
                )) {
            $err = 'Ya existe un alumno con este dni/nie';
        } elseif (!$this->getSql('nombre') || !$this->getSql('apellidos')) {
            $err = 'Debe introducir el nombre y los apellidos del alumno';
        } elseif (!datecheck($this->getPostParam('fechaNac'))) {
            $err = 'Debe introducir una fecha de nacimiento correcta' . $this->getPostParam('fechaNac');
        } elseif (!array_key_exists('sexo', $_POST)) {
            $err = "Seleccione Hombre o Mujer";
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    private function _tituloPagina($idFichaCurso)
    {
        $datosCurso = $this->_crearNombreCurso($idFichaCurso);
        $this->_view->assign('titulo', "Matricular alumno <small>$datosCurso</small>");
    }

    public function borrarMatricula($idFichaCurso, $idAlumno)
    {
        Session::acceso('usuario');

        $id = $this->_model->getIdABorrar($idFichaCurso, $idAlumno);
        $fichaCurso = $this->_model->getCursoById($idFichaCurso);
        $alumno = $this->_model->getById('alumnos', $idAlumno);

        $nombreAlumno = capitalizar($alumno['nombre'] . ' ' . $alumno['apellidos']);

        Session::set('nombre_borrado', $nombreAlumno);
        $reg_borrado = Session::get('nombre_borrado');

        $pagina = Session::get('pagina'); //página del listado que se visualiza


        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
            exit;
        }

        $url = BASE_URL . $this->_modulo . '/ver/' . $id;

        $table = 'ficha_alumnos';
        $error = "<div class='text-center'>Error al borrar ";


        if (!$this->_model->getById($table, ($this->filtrarInt($id)))) {
            $error .= "no se encuentra el registro.";
            $error .= "</div>";
            Session::set('error', $error);
            Session::destroy('nombre_borrado');
            $this->redireccionar($this->_modulo . '/ver/' . $idFichaCurso);
            exit;
        }
        if (!$this->_model->eliminarRegistro($table, ($this->filtrarInt($id)))) {
            Session::destroy('nombre_borrado');
            if (!empty($reg_borrado)) {
                $error .= " el registro correspondiente a <a href='" . $url . "'><strong>" . $reg_borrado . "</strong></a>";
            }
            $error .= "</div>";
            $error .= "<div class='text-center'>Es posible que haya registros en otras tablas que dependan de este.</div>";
            Session::set('error', $error);
            $this->redireccionar($this->_modulo . '/ver/' . $idFichaCurso);
            exit;
        } else {
            $this->redireccionar($this->_modulo . '/ver/' . $idFichaCurso);
        }
    }

    /**
     * Devuelve array ordenado con profesores ACTIVOS para colocar en combo
     * 
     * @param array $profesores tabla de profesores
     * @return array
     */
    private function _profActivos(array $profesores)
    {
        $profActivos = array();

        for ($index = 0; $index < count($profesores); $index++) {
            if ($profesores[$index]['estado'] == 1) {
                $profActivos[] = array(
                    'id' => $profesores[$index]['id'],
                    'nombre' => $this->getNombreApellido($profesores[$index]));
            }
        }

        array_unshift($profActivos, array(
            'id' => '0',
            'nombre' => ''));

//ordenar array
        usort($profActivos, function($a, $b) {
            return strtolower(limpiar($b['nombre'])) < strtolower(limpiar($a['nombre']));
        });

        return $profActivos;
    }

//    private function _prueba() {
//        $arr[] = array('id' => 1, 'nombre' => 'Juan');
//        $arr[] = array('id' => 3, 'nombre' => 'Felipe');
//        $arr[] = array('id' => 2, 'nombre' => 'Ana');
//        $arr[] = array('id' => 20, 'nombre' => 'Ana');
//        $arr[] = array('id' => 12, 'nombre' => 'Ana');
//        vardump($arr);
//
//
//        usort($arr, function($a, $b) {
//            return $b['nombre'] < $a['nombre'];
//        });
//        vardumpy($arr);
//    }

    public function editarMatricula($idFichaAlumno)
    {
        $ficha = $this->_model->getById('ficha_alumnos', $idFichaAlumno);
//        vardumpy($ficha);

        $this->_tituloPagina($ficha['id_ficha_curso']);


//        vardumpy($this->_crearNombreCurso($ficha['id_ficha_curso']));
        $this->_view->assign('curso', $this->_crearNombreCurso($ficha['id_ficha_curso']));

        $idFichaCurso = $ficha['id_ficha_curso'];

//        $alumno = $this->_model->getById('alumnos', $ficha['id_alumno']);
//        $dni = $alumno['dni'];
//        
//        puty(__METHOD__ . $idFichaMatricula);

        $alumno = $this->_model->getById('alumnos', $ficha['id_alumno']);
        $this->matricularAlumno($idFichaAlumno, $alumno['id']);
        exit;

        Session::acceso('usuario');
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $this->redireccionar('error/access/804/' . __METHOD__ . '/' . $id);
            exit;
        }

        $cursos = $this->pasarTablaACombo('cursos');
        $centros = $this->pasarTablaACombo('centros');
        $profesores = $this->pasarTablaACombo('usuarios');

        $this->_view->assign('titulo', "Editar curso");
        $this->_view->assign('cursos', $cursos);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('profesores', $profesores);

        $this->_view->setJs(array('nuevo'));

        if ($this->getInt('guardar') == 1) {

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':id_curso' => $this->getInt('id_curso'),
                ':id_centro' => $this->getInt('id_centro'),
                ':id_profesor' => $this->getInt('id_profesor'),
                ':fecha_inicio' => $this->getPostParam('fecha_inicio'),
                ':fecha_fin' => $this->getPostParam('fecha_fin'),
                ':hora_inicio' => $this->getPostParam('hora_inicio'),
                ':hora_fin' => $this->getPostParam('hora_fin'),
                ':horas_totales' => $this->getInt('horas_totales'),
                ':modificador' => Session::getId(),
                ':fecha_modificacion' => date('Y-m-d H:i:s')
            );

            $this->_model->editarRegistro($this->_table, $id, $campos);
            if ($id == Session::getId()) {
                Session::set('nombre', $this->getPostParam('nombre'));
            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;


            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">'
                    . $this->_crearNombreCurso($id) . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

//        vardump($this->_model->getById(
//                        $this->_table, $this->filtrarInt($id)));
        $this->_view->assign('datos', $this->_model->getById(
                        $this->_table, $this->filtrarInt($id)));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    public function volver($modulo = false, $pag = false)
    {
        parent::volver($this->_modulo, Session::get('pagina_ficha_cursos'));
    }

    public function certificado($idFichaCurso, $idAlumno)
    {

        $a_fichaCurso = $this->_model->getById('ficha_cursos', $idFichaCurso);
        $a_alumno = $this->_model->getById('alumnos', $idAlumno);

        $fecha = FechaHora::fechaATexto($this->getPostParam('fecha_certificado'));
        $margen = $this->getInt('margen');
        $alumno = capitalizar($a_alumno['nombre'] . ' ' . $a_alumno['apellidos']);
        $dni = $a_alumno['dni'];

        $curso = $this->_model->getNamebyId('cursos', $a_fichaCurso['id_curso']);
        $centro = $this->_model->getNamebyId('centros', $a_fichaCurso['id_centro']);
        $profesor = $this->_model->getNamebyId('usuarios', $a_fichaCurso['id_profesor']);
        $fechaCurso = FechaHora::fechaATexto($a_fichaCurso['fecha_inicio']);
        $h1 = FechaHora::HoraCorta($a_fichaCurso['hora_inicio']);
        $h2 = FechaHora::HoraCorta($a_fichaCurso['hora_fin']);
        $h3 = $a_fichaCurso['horas_totales'];

        $filename = FechaHora::Hoy(FechaHora::HOY_INVERSO);
        $filename .= '-' . $alumno .'.pdf';

        $head = "Santander, {$fecha}";

        $body = "D. <strong>{$alumno}</strong> con DNI/NIE/Pasaporte nº <strong>{$dni}</strong> ha asistido al curso de <strong>{$curso}</strong>, realizado en el <strong>{$centro}</strong> de Santander durante la semana del <strong>{$fechaCurso}</strong>, en horario de <strong>{$h1}</strong> a <strong>{$h2}</strong> horas, con un total de <strong>{$h3}</strong> horas.";

        $foot = "<br>" . $centro . "<br>Santander<br>942 203 030";



        $html = <<<EOT
                <style>
                    p.head{
                        text-align: right;
                        line-height: 1500%;
                    }
                    p.body{
                        padding: 150px;
                        text-align: justify;
                        line-height: 175%;
                        }
                    .blanco2{
                        color:#fff;
                        line-height: 1000%;
                        }
                    p.foot{
                        padding: 150px;
                        text-align: right;
                        line-height: 200%;
                        }
                </style>
                <p class="head">{$head}</p>
                
                <p class="body">D. <strong>{$alumno}</strong> con DNI/NIE/Pasaporte nº <strong>{$dni}</strong> ha asistido al curso de <strong>{$curso}</strong>, realizado en el <strong>{$centro}</strong> de Santander durante la semana del <strong>{$fechaCurso}</strong>, en horario de <strong>{$h1}</strong> a <strong>{$h2}</strong> horas, con un total de <strong>{$h3}</strong> horas.</p>
                <div class="blanco2">x</div>
                <p class="foot">{$foot}</p>
EOT;


        include ROOT . 'controllers' . DS . 'pdfController.php';
        $pdf = new pdfController();
        $pdfFile = $html;
        $subject = 'Certificado del curso " ' . $curso . '"';

        $pdf->certificado($pdfFile, $filename, $subject, $margen);
    }

    private function _crearTitulo($filtro)
    {
//        vardump($filtro);
        $titulo = 'Listado de cursos';
        if (array_key_exists('id_centro', $filtro)) {
            if ($filtro['id_centro'] != 99 && $filtro['id_centro'] != 0) {
                $centro = $this->_model->getCentro($filtro['id_centro']);
            } elseif ($filtro['id_centro'] == 0) {
                $centro = $this->_model->getCentro($this->_model->getCentroByUserId(Session::getId()));
            } else {
                $centro = "TODOS";
            }
        } else {
            if (!Session::esAdmin()) {
                $centro = $this->_model->getCentro($this->_model->getCentroByUserId(Session::getId()));
            } else {
                $centro = "Vista de Administrador";
            }
        }
        $titulo .= " <small>" . $centro;

        $curso = null;
        if (array_key_exists('id_curso', $filtro) && $filtro['id_curso'] > 0) {
            $curso = " &mdash; " . $this->_model->getCurso($filtro['id_curso']);
        }
        $titulo .=$curso;

        if (array_key_exists('desde', $filtro) && !empty($filtro['desde'])) {
            $fd = FechaHora::fechaCorta($filtro['desde'], true);
        } else {
            $fd = FechaHora::fechaCorta(FechaHora::lunesAnterior(), true);
        }


        $desde = null;
        $hasta = null;
        if (array_key_exists('hasta', $filtro) && !empty($filtro['hasta'])) {
            $desde = " &mdash; De " . $fd;
            $hasta .= " a " . FechaHora::fechaCorta($filtro['hasta'], true);
        } else {
            $desde = " &mdash; Desde " . $fd;
//                $hasta = " &mdash; hasta " . FechaHora::fechaCorta($filtro['hasta'], true);
        }

        $titulo .= $desde;

        $titulo .= $hasta;

        $titulo .= "</small>";

        return $titulo;
    }

    private function _crearComboCentros()
    {
        $centros = $this->_model->getTabla('centros');

        array_unshift($centros, array(
            'id' => '99',
            'nombre' => 'Todos'));
        if (!Session::esAdmin()) {
            array_unshift($centros, array(
                'id' => '0',
                'nombre' => 'Centro Actual'));
        }
        return $centros;
    }

    public function hojaCurso()
    {
        $filtro = Session::get('filtro');
//        vardumpy($_POST);
        //Poner la fecha si no existe
        if (empty($filtro['desde'])) {
            $filtro['desde'] = FechaHora::lunesAnterior();
        }

        $cursos = $this->_model->getDatosHoja($filtro);

        include ROOT . 'controllers' . DS . 'pdfController.php';
        $pdf = new pdfController('L');

        $conAlumnos = false;
        if ($this->getPostParam('alumnos')) {
            $conAlumnos = true;
        }

        $pdf->imprimirHojaCurso($cursos, $conAlumnos);
    }

    public function getUsuarios_ajax()
    {
        if ($this->getInt('id_centro')) {
            $usuarios = $this->_model->getUsuariosActivos();
//                    $this->_model->getUsuarios_ajax($this->getInt('id_centro'));
            for ($i = 0; $i < count($usuarios); $i++) {
                $usuarios[$i]['nombre'] = $this->getNombreApellido($usuarios[$i]);
            }
            echo json_encode($usuarios);
        }
    }
}
