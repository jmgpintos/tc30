<?php

class incidenciasController extends Controller {

    protected $_table = 'incidencias';
    protected $_modulo = 'incidencias';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('incidencias');
    }

    /**
     * Listado de incidencias
     * 
     * @param int $pag Página del listado a mostrar
     */
    public function index($pag = 1)
    {
        Session::acceso('usuario');
        $pagina = $this->filtrar_pagina($pag);
        $this->_view->setJs(array('confirmarBorrar'));

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
            Session::set('mensaje', $this->_mensaje);
        }

        $centro = null;
        if (!Session::esEspecial()) {
            $centro = $this->_model->getCentroByUserId();
            if (!$centro) {
                $this->_mensaje = "El dinamizador <strong>" . Session::get('nombre')
                        . "</strong> no tiene centro asignado";
                Session::set('error', $this->_mensaje);
            }
            $datos = $this->_model->getIncidenciasPorCentro($centro);
            $nombreCentro = $this->_model->getNameById('centros', $centro);
        } else {
            $datos = $this->_model->getIncidenciasPorCentro($centro);
        }
        $this->asignar_mensajes();

        $titulo = 'Listado de incidencias';

        if (isset($nombreCentro)) {
            $titulo .= " <small>" . $nombreCentro . "</small>";
        }

        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index]['row'] = $index + 1;
            $datos[$index] = $this->formato_datos($datos[$index]);
        }
        
        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);

        $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', $titulo);
        $this->_view->assign('es_busqueda', FALSE); //para poner el icono de "ver todos"
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Ver ficha de incidencia
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
        $this->_view->setJs(array('confirmarBorrar'));
//        $this->asignar_mensajes();
//        vardumpy($this->_model->getById($this->_table, $this->filtrarInt($id)));

        $datos = $this->formato_datos($this->_model->getById($this->_table, $this->filtrarInt($id)));

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('titulo', "Ficha de la incidencia");
        $this->_view->assign('datos', $datos);
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/ver/' . $id));
        $this->_view->assign('hoy', FechaHora::Hoy('html5'));

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

        $this->_view->assign('titulo', "Editar incidencia");
        $this->_view->setJs(array('nuevo', 'datepicker'));

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);
            $this->_view->assign('datos', $_POST);

            if (!$this->comprobar_datos('editar')) {
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            $campos = array(
                ':descripcion' => $this->getSql('descripcion'),
                ':solucion' => $this->getSql('solucion'),
                ':fecha_cierre' => $this->getTexto('fecha_cierre'),
                ':estado' => 1            );
            $this->_model->editarRegistro($this->_table, $id, $campos);

            if ($id == Session::getId()) {
                Session::set('nombre', $this->getPostParam('nombre'));
            }
            $url = BASE_URL . $this->_modulo . '/ver/' . $id;

            $this->_mensaje = 'Se ha modificado el registro correspondiente a <hr/>' . $this->_descripcionIncidencia($id);

            Session::set('mensaje', $this->_mensaje);

            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $datos = $this->_model->getById($this->_table, $this->filtrarInt($id));
        $datos = $this->formato_datos($datos, 'editar');
//        vardump($datos);

        $this->_view->assign('datos', $datos);

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    /**
     * Nueva incidencia
     */
    public function nuevo()
    {
        Session::acceso('usuario');

        if (!Session::esEspecial()) {
            $centro = $this->_model->getCentroByUserId();
        }

        $this->_view->assign('titulo', 'Nueva Incidencia');

        $this->_view->setJs(array('nuevo'));


        $equipos = $this->pasarTablaACombo('equipos', '', false);
        $equipos = $this->_model->buscarRegistro('equipos', array(array('id_centro', "=", $centro)));

        $equipos = $this->pasarArrayACombo($equipos, '');

        $tipos = $this->pasarTablaACombo('tipo', '');
        $centros = $this->pasarTablaACombo('centros', '', false);

        $this->_view->assign('centro', $centro);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('equipos', $equipos);
        $this->_view->assign('tipos', $tipos);

        if ($this->getInt('guardar') == 1) {
            $this->_view->assign('datos', $_POST);
            if (!$this->comprobar_datos('nuevo')) {
                $this->_view->renderizar_template('nuevo', $this->_modulo);
                exit;
            }

            //Añadir registro a la tabla
            $this->_model->insertarRegistro(
                    $this->_table, array(
                'id_equipo' => $this->getInt('id_equipo'),
                'id_centro' => $centro,
                'id_usuario' => Session::getId(),
                'tipo' => $this->getInt('id_tipo'),
                'fecha_creacion' => FechaHora::Hoy(),
                'descripcion' => $this->getPostParam('descripcion')
                    )
            );

            //Comprobar si se ha escrito el registro en la tabla
            if (!$this->_model->existeRegistro(
                            $this->_table, array(
                        'id_centro' => $centro,
                        'id_usuario' => Session::getId(),
                        'tipo' => $this->getInt('id_tipo'),
                        'fecha_creacion' => FechaHora::Hoy()
                            )
                    )) {
                $this->_view->assign('error', 'Error al registrar la incidencia');
                $this->index();
                exit;
            }

            $this->_view->assign('datos', false);
            $id = $this->_model->getLastID();

            $url = BASE_URL . $this->_modulo . '/ver/' . $id;
            $nombreEquipo = $this->_model->getNameById('equipos', $this->getInt('id_equipo'));
            $nombreCentro = $this->_model->getNameById('centros', $centro);
            $mensaje = 'Se ha creado un nuevo registro para el equipo <a href = "' . $url . '"><strong>'
                    . "{$nombreEquipo} </strong>en<strong> {$nombreCentro} "
                    . '</strong></a>';
            Session::set('mensaje', $mensaje);

            $this->redireccionar($this->_modulo);
        }

        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    /**
     * Eliminar alumno con id = $id
     * 
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {
        Session::acceso('especial');

        Session::set('nombre_borrado', capitalizar($nombre));
        parent::eliminar($id, $this->_modulo);
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

        if ($accion == 'nuevo') {
            if (!$this->getInt('id_equipo')) {
                $err = "equipo";
            } elseif (!$this->getInt('id_tipo')) {
                $err = "tipo";
            } elseif (!$this->getPostParam('descripcion')) {
                $err = "descripcion";
            }
        } elseif ($accion == 'editar') {
            /*
             * 
              ["descripcion"]=>
              string(21) "El monitor se ve azul"
              ["solucion"]=>
              string(0) ""
              ["fecha_cierre"]=>
              string(0) ""
             */

            if (!$this->getPostParam('descripcion')) {
                $err = "descripcion";
            } elseif (!$this->getPostParam('solucion')) {
                $err = "solucion";
            } elseif (!$this->getPostParam('fecha_cierre')) {
                $err = "fecha_cierre";
            }
        }
        //comprobaciones para cada caso

        if ($err) {
            $err = "Complete el campo <strong>{$err}</strong>";
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Da formato a los datos antes de enviarlos a la plantilla de la vista
     * 
     * @param array $datos recordset con los datos a mostrar
     * @return array
     */
    public function formato_datos($datos, $accion = FALSE)
    {
        $datos['centro'] = $this->_model->getCentros($datos['id_centro']);
        $datos['equipo'] = capitalizar($this->_model->getEquipos($datos['id_equipo']));
        $datos['txt_tipo'] = $this->_model->getTipo($datos['tipo']);
        $datos['usuario'] = $this->_model->getNameById('usuarios', $datos['id_usuario']);
        $datos['tecnico'] = $this->getNombreApellido($datos['usuario']);

        if (!$accion) {//tratar fechas solo cuando se está viendo, no en editar
            if ($datos['fecha_creacion']) {
                $datos['fecha_creacion'] = FechaHora::fechaATexto(substr($datos['fecha_creacion'], 0, 10));
            } else {
                $datos['fecha_creacion'] = '-';
            }

            if ($datos['fecha_cierre']) {
                $datos['fecha_cierre'] = FechaHora::fechaATexto(substr($datos['fecha_cierre'], 0, 10));
            } else {
                $datos['fecha_cierre'] = '-';
            }
        }

        return $datos;
    }

    private function _descripcionIncidencia($id)
    {
        $msg = null;

        $incidencia = $this->_model->getById('incidencias', $id);

        $centro = $this->_model->getNameById('centros', $incidencia['id_centro']);
        $equipo = $this->_model->getNameById('equipos', $incidencia['id_equipo']);
        $tipo = $this->_model->getNameById('tipo', $incidencia['tipo']);
        $fechaCreacion = date('Y-m-d', strtotime($incidencia['fecha_creacion']));
        $fecha = FechaHora::fechaATexto($fechaCreacion);

        $msg .= "<div class='col-md-10 col-md-push-2'>";
        $msg .= "Centro: <strong>" . $centro . "</strong><br>";
        $msg .= "Equipo: <strong>" . $equipo . "</strong><br>";
        $msg .= "Tipo de incidencia: <strong>" . $tipo . "</strong><br>";
        $msg .= "Fecha: <strong>" . $fecha . "</strong><br>";
        $msg .= "</div>";

        return $msg;
    }

}
