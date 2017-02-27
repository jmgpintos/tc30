<?php

class alumnoController extends Controller {

    protected $_table = 'alumnos';
    protected $_modulo = 'alumno';
    
    const VAR_PAGE_NAME = 'pagina_alumnos';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('alumno');
    }

    /**
     * Listado de alumnos
     * 
     * @param int $pag Página del listado a mostrar
     */
    public function index($pag = 1)
    {
        Session::acceso('usuario');
        if (Session::get('sql')) {
            $this->resultados_busqueda(Session::get('pagina'));
            exit;
        }
        $pagina = $this->filtrar_pagina($pag);
        $this->_view->setJs(array('confirmarBorrar'));
//        $this->limpiar_busqueda();

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
            $datos[$index] = $this->formato_datos($datos[$index]);
        }

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set(self::VAR_PAGE_NAME, $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', 'Listado de alumnos');
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Crear nuevo alumno
     */
//    public function nuevo()
//    {
//        Session::acceso('especial');
//
//        $this->_view->assign('titulo', 'Nuevo dinamizador');
//
//        $this->_view->setJs(array('nuevo'));
//
//        if ($this->getInt('guardar') == 1) {
//
//            $this->_view->assign('datos', $_POST);
//            if (!$this->comprobar_datos('nuevo')) {
//                $this->_view->renderizar_template('nuevo', $this->_modulo);
//                exit;
//            }
//
//            //Añadir registro a la tabla
//            $this->_model->insertarRegistro(
//                    $this->_table, array(
//                ':nombre' => $this->getPostParam('nombre'),
//                ':usuario' => $this->getPostParam('usuario'),
//                ':password' => Hash::getHash('sha1', $this->getPostParam('password'), HASH_KEY),
//                ':email' => $this->getPostParam('email'),
//                ':telefono' => $this->getPostParam('telefono'),
//                ':role' => DEFAULT_ROLE,
//                ':estado' => 1,
//                ':fecha' => date('Y-m-d H:i:s'),
//                ':ultimo_acceso' => null,
//                ':id_centro' => $this->getPostParam('id_centro')
//                    )
//            );
//
//            //Comprobar si se ha escrito el registro en la tabla
//            if (!$this->_model->existe_registro(
//                            $this->_table, array('usuario' => $this->getAlphaNum('usuario'))
//                    )) {
//                $this->_view->assign('_error', 'Error al registrar el usuario');
//                $this->_view->renderizar_template('index', $this->_modulo);
//                exit;
//            }
//
//            $this->_view->assign('datos', false);
//            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong>' . $this->getPostParam('nombre') . '</strong>');
//
//            $this->redireccionar($this->_modulo);
//        }
//
//        $this->_view->renderizar_template('nuevo', $this->_modulo);
//    }

    /**
     * Ver ficha de alumno (y subtabla con cursos)
     * 
     * @param int $id
     * @param int $pagina
     */
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
        $this->_view->setJs(array('confirmarBorrar', 'obtenerCertificado'));
//        $this->asignar_mensajes();

        $datos = $this->formato_datos($this->_model->getById($this->_table, $this->filtrarInt($id)));
//        $old_datos = $datos;
//        $datos = $this->formato_datos($datos);
//        $datos['fechaNac'] = FechaHora::fechaATexto($old_datos['fechaNac'], TRUE);

        $cursos = $this->getCursos($id);

//        vardump($datos);
//        vardumpy($cursos);

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('titulo', "Ficha del alumno");
//        $this->_view->assign('controlador', 'alumno');
        $this->_view->assign('datos', $datos);
        $this->_view->assign('cursos', $paginador->paginar($cursos, $pagina, 10));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $id));
        $p = $paginador->get_paginacion();
        $this->_view->assign('paginas', ($p['total'] > 1));
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));
        $this->_view->assign('ref', $_SERVER['HTTP_REFERER']);

        $this->_view->renderizar_template('ver', $this->_modulo);
    }

    /**
     * Editar alumno con id = $id
     * 
     * @param int $id
     */
    public function editar($id)
    {
        Session::acceso('usuario');
//        Session::set('editando_id', $id);
        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo . '/' . $id);
            exit;
        }

        $this->_view->assign('titulo', "Editar alumno");
        $this->_view->setJs(array('nuevo','datepicker'));

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
                ':fechaNac' => $this->getPostParam('fechaNac'),
                ':telefono' => $this->getPostParam('telefono'),
                ':sexo' => substr($this->getPostParam('sexo'), 0, 1),
                ':discapacidad' => $this->getPostParam('discapacidad') ? 1 : 0,
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
    public function eliminar($id, $controlador = false, $acceso = Session::ROLE_SPECIAL, $pagina=self::VAR_PAGE_NAME)
    {
        Session::acceso('especial');
        $alumno = $this->_model->getById($this->_table, $id);
        $nombre = $alumno['apellidos'];
        $nombre .= ', ' . $alumno['nombre'];

        Session::set('nombre_borrado', capitalizar($nombre));
        parent::eliminar($id, $this->_modulo,$acceso, $pagina);
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
     * Lista los resultsados de la búsqueda
     * 
     * @param int $pagina página del listado
     */
    public function resultados_busqueda($pagina = 1)
    {

        Session::acceso('usuario');
        $pagina = $this->filtrar_pagina($pagina);

        $datos = $this->_model->getSQL(Session::get('sql'));
        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index]['row'] = $index + 1;
            $datos[$index] = $this->formato_datos($datos[$index]);
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
     * Comprobar que los datos introducidos en los formularios son correctos
     * 
     * @param string $accion 'nuevo'|'editar' para saber qué campos se deben validar
     * @return boolean
     * 
     */
    private function comprobar_datos($accion = false)
    {
        $err = null;
//        put(__METHOD__);
//        vardump($_POST);
        //Comprobaciones comunes
        if (strtoupper(substr($this->getAlphaNum('dni'), 0, 1)) == 'N') {// es niño
            //calcular numero niño
            $_POST['dni'] = $this->_model->GetDniNino();
        } elseif (!comprobar_letra_nif($this->getAlphaNum('dni'))) {
//            $err = 'NIF/NIE incorrecto';
        }

        if (!$err) {
            if (!$this->getSql('nombre') || !$this->getSql('apellidos')) {
                $err = 'Debe introducir el nombre y los apellidos del usuario';
            } elseif (!datecheck($this->getPostParam('fechaNac'))) {
                $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fechaNac');
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
     * Da formato a los datos antes de enviarlos a la plantilla de la vista
     * 
     * @param array $datos recordset con los datos a mostrar
     * @return array
     */
    public function formato_datos($datos)
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
     * Código para el botón "ver todo" (en búsqueda)
     */
    public function ver_todo()
    {
        Session::destroy('sql');
        Session::destroy('buscar');
        $this->index(Session::get('pagina'));
    }

    /**
     * Devuelve los cursos del alumno con id = $id con el formato adecuado 
     * para asignarlos a la plantilla de la vista
     * 
     * @param int $id
     * @return array
     */
    public function getCursos($id)
    {
        $cursos = $this->_model->get_cursos_alumno($this->filtrarInt($id));
        for ($index = 0; $index < count($cursos); $index++) {
            $cursos[$index]['row'] = $index + 1;
            $cursos[$index]['hora_inicio'] = substr($cursos[$index]['hora_inicio'], 0, 5);
            $cursos[$index]['fecha_inicio'] = FechaHora::fechaCorta($cursos[$index]['fecha_inicio']);
            $cursos[$index]['nombre_centro_elipsis'] = ellipsis($cursos[$index]['nombre_centro']);
            $cursos[$index]['nombre_curso_elipsis'] = ellipsis($cursos[$index]['nombre_curso'], 20);
        }
        return $cursos;
    }

    public function volver($modulo=false, $pag = false)
    {
        parent::volver($this->_modulo);
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

    public function capitalizarNombres()
    {
        //IMPORTANTE: Desactivar log para hacer esto
        $alumnos = $this->_model->getAll('alumnos');

        $alumnos = array_slice($alumnos, 5200, 400); //en tramos de 400 para que no de timeout

        put(count($alumnos));
        for ($i = 0; $i < count($alumnos); $i++) {
            $campos = array(
                'nombre' => capitalizar($alumnos[$i]['nombre']),
                'apellidos' => capitalizar($alumnos[$i]['apellidos'])
            );
            $this->_model->editarRegistro('alumnos', $alumnos[$i]['id'], $campos);
        }
        put($alumnos[count($alumnos) - 1]['id']);
    }

}
