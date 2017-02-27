<?php

class acceso_libreController extends Controller {

    protected $_table = 'acceso_libre';
    protected $_modulo = 'acceso_libre';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('acceso_libre');
    }

    /**
     * Listado de usuarios de acceso_libre
     * 
     * @param int $pag Página del listado a mostrar
     */
    public function index($pag = 1)
    {
        Session::acceso('usuario');
        if ($this->vieneDeFuera()) {
            //Viene de fuera
            Session::destroy('centro_acceso');
        }

//        put(Session::get('centro_acceso'));
        $pagina = $this->filtrar_pagina($pag);
        $this->_view->setJs(array('confirmar'));

        if (in_array($this->getInt('centro'), $_POST)) {
            $pagina = 1;
            $centroSeleccionado = $this->getInt('centro');
        } else {
            $centroSeleccionado = Session::get('centro_acceso');
        }
        
        $centros = $this->pasarTablaACombo('centros', '', false);
        if (Session::esEspecial()) {
            $centros = $this->pasarTablaACombo('centros', 'Todos');
        } else {
            if (!$centroSeleccionado) {
                $centros = $this->pasarTablaACombo('centros', 'Seleccione centro');
            }
        }

        if ($centroSeleccionado > -1) {
            Session::destroy('centro_acceso');
            Session::set('centro_acceso', $centroSeleccionado);
        } elseif (Session::get('centro_acceso')) {
            $centroSeleccionado = Session::get('centro_acceso');
        } else {
            //leer y asignar centro del dinamizador
            if (!Session::esEspecial()) {
                $centroSeleccionado = $this->_model->getCentroByUserId();
            }
            if (!$centroSeleccionado && !(Session::esEspecial() || Session::esAdmin())) {
                $centroSeleccionado = 0;
//                $this->_error = "El dinamizador <strong>" . Session::get('nombre')
//                        . "</strong> no tiene centro asignado"
//                        . "<hr/> <div class='text-center'><small>Consulte con el ser superior</small></div>";
//                Session::set('error', $this->_mensaje);
            }
        }

        $this->asignar_mensajes();

        //traer datos de la tabla
        $datos = $this->_formato_datos(
                $this->_model->getAllAccesoLibre($centroSeleccionado));

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);

        if ($centroSeleccionado == 0) {
            $nombreCentro = "Todos los telecentros";
        } else {
            $nombreCentro = $this->_model->getNameById('centros', $centroSeleccionado);
        }

        $pag = null;
        if ($datos) {
            $pag = $paginador->paginar($datos, $pagina, LINES_PER_PAGE);
        }
        $this->_view->assign('datos', $pag);
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('centro', $centroSeleccionado);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('nombre_centro', $nombreCentro);
        $this->_view->assign('titulo', $this->_getTitulo($centroSeleccionado));
        $this->_view->assign('cuenta', count($datos));
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    public function nuevo($idCentro)
    {

//        vardump($_POST);
        Session::acceso('usuario');
        if (!$this->filtrarInt($idCentro)) {
            puty(__METHOD__);
            $this->redireccionar($this->_modulo);
        }

//        $this->_view->setJs(array());

        if ($this->getInt('guardar') == 1) {
//            vardumpy($_POST);
            $this->_view->assign('datos', $_POST);

            //Comprobar si DNI existe
            $dni = $this->getAlphaNum('dni');
//            puty(substr($dni,0,1));
            if (strtoupper(substr($dni, 0, 1)) == 'N') {// es niño
                //calcular numero niño
                $dni = $this->_model->GetDniNino();
//                puty($dni);
            } elseif (!comprobar_letra_nif($dni)) {
                $error = '<strong>DNI/NIF no válido</strong><br/>';
                $this->_view->assign('error', $error);

                $this->_view->assign('dni', $dni);

                $this->_view->assign('equiposLibres', $this->_model->getEquiposLibres($idCentro));
                $this->_view->assign('equipo', $this->getInt('equipo'));
                $this->_view->assign('titulo', $this->_getTitulo($centroSeleccionado));
                $this->_view->renderizar_template('nuevo_acceso', $this->_modulo);

                exit;
            }
            $alumno = $this->_comprobar_dni($dni);
            if (!$alumno) {//Nuevo usuario, pedir datos
                $mensaje = "<strong>Nuevo usuario</strong><hr/>"
                        . "<div class='text-center'>Introduzca los datos</div>";
                $this->_view->assign('mensaje', $mensaje);

                $datosNuevoAcceso = array(
                    'id_centro' => $idCentro,
                    'id_equipo' => $this->getInt('equipo')
                );

                $this->nuevoUsuarioAccesoLibre($dni, $datosNuevoAcceso);
                exit;
            } else {//Insertar registro en acceso libre
//                vardump($alumno);
                $campos = array(
                    'id_alumno' => $alumno['id'],
                    'id_centro' => $idCentro,
                    'id_equipo' => $this->getInt('equipo')
                );

//                put('existe');
//                vardumpy($campos);
                $this->_model->insertarRegistro($this->_table, $campos);

//                $url = BASE_URL . $this->_modulo . '/ver/' . $id;

                $this->_mensaje = 'Se ha inciado una nueva sesi&oacute;n para  <strong>'
                        . capitalizar($alumno['apellidos'] . ', ' . $alumno['nombre']) . '</strong>';
                Session::set('mensaje', $this->_mensaje);
            }




            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $equipos = $this->_model->getEquiposLibres($idCentro);
        $centros = $this->_model->getAll('centros');
        $nombreCentro = $this->_model->getNameById('centros', $idCentro);

        $this->_view->assign('titulo', "Nuevo Registro de Acceso Libre");
        $this->_view->assign('centro', $nombreCentro);
        $this->_view->assign('centros', $centros);
        $this->_view->assign('equiposLibres', $equipos);
//        $this->_view->assign('datos', $this->_model->getById(
//                        $this->_table, $this->filtrarInt($id)));
        //pedir DNI y ordenador
        $this->_view->renderizar_template('nuevo_acceso', $this->_modulo);
    }

    public function nuevoUsuarioAccesoLibre($dni = false, $datosNuevoAcceso = false)
    {
        if (strtoupper($dni) == 'N') {
            $dni = Session::get('dni');
        }
//        puty($dni);
        if ($dni) {
//            puty(__METHOD__);
            Session::set('dni', $dni);
        }
        if ($datosNuevoAcceso) {
            Session::set('datos_nuevo_acceso', $datosNuevoAcceso);
        }
        $this->_view->assign('titulo', "Nuevo usuario de acceso libre");
        $this->_view->assign('dni', $dni);
        $this->_view->assign('controlador', $this->_modulo);
        if ($this->getInt('guardar_nuevo_usuario') == 1) {
//            puty($dni);
            if (!$datosNuevoAcceso) {
                $datosNuevoAcceso = Session::get('datos_nuevo_acceso');
                $dni = Session::get('dni');
            }

            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatosAlumno()) {
                $this->_view->renderizar_template('nuevo_usuario', $this->_modulo);
                exit;
            }
            //Insertar registro en tbl_alumnos
            $campos = array(
                ':dni' => $dni,
                ':nombre' => $this->getTexto('nombre'),
                ':apellidos' => $this->getTexto('apellidos'),
                ':fechaNac' => $this->getPostParam('fechaNac'),
                ':telefono' => $this->getPostParam('telefono'),
                ':sexo' => substr($this->getPostParam('sexo'), 0, 1),
                ':discapacidad' => $this->getPostParam('discapacidad') ? 1 : 0,
                ':fecha_alta' => date('Y-m-d'),
                ':creador' => Session::getId()
            );
            $this->_model->insertarRegistro('alumnos', $campos);

            //Comprobar si se ha escrito el registro en la tabla
            $lastID = $this->_model->getLastID();
            if (!$this->_model->existeRegistro(
                            'alumnos', array('id' => $lastID)
                    )) {
                //fallo al insertar registro en tabla alumnos
                Session::set('error', 'Error al registrar el usuario');
                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            //Insertar registro en acceso libre
            $datosNuevoAcceso = Session::get('datos_nuevo_acceso');

            $campos = array(
                'id_alumno' => $lastID,
                'id_centro' => $datosNuevoAcceso['id_centro'],
                'id_equipo' => $datosNuevoAcceso['id_equipo']
            );

            Session::destroy('datos_nuevo_acceso');
            Session::destroy('dni');

            $this->_model->insertarRegistro($this->_table, $campos);
            $lastID = $this->_model->getLastID();

            if (!$this->_model->existeRegistro(
                            $this->_table, array('id' => $lastID)
                    )) {
                //fallo al insertar registro en tabla acceso_libre
                Session::set('error', 'Error al registrar el acceso');
                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_mensaje = 'Se ha inciado una nueva sesi&oacute;n para  <strong>'
                    . capitalizar($this->getTexto('apellidos') . ', ' . $this->getTexto('nombre')) . '</strong>';
            Session::set('mensaje', $this->_mensaje);

            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->renderizar_template('nuevo_usuario', $this->_modulo);
    }

    public function cerrarTodas($idCentro)
    {
        $this->_model->cerrarTodas($idCentro);
        $this->redireccionar('acceso_libre');
    }

    public function cerrarSesionesAnteriores($centroSeleccionado)
    {
        $this->_model->cerrarSesionesAnteriores($centroSeleccionado);
        $this->redireccionar('acceso_libre');
    }

    public function finalizar($id)
    {
        $this->_model->finalizarSesionAccesoLibre($id);
        $this->_mensaje = "Sesión de acceso libre finalizada";
        $this->redireccionar('acceso_libre');
    }

    private function _formato_datos($datos)
    {
        for ($index = 0; $index < count($datos); $index++) {
            $datos[$index]['row'] = $index + 1;

            //centro
            $datos[$index]['centro'] = $this->_model->getNameById('centros', $datos[$index]['id_centro']);
//        put(__METHOD__);
//            vardumpy(  $datos[$index]['centro']);
            //equipo
            $equipo = $this->_model->getById('equipos', $datos[$index]['id_equipo']);
            $datos[$index]['equipo'] = $equipo['nombre'];


            //alumno
            $alumno = $this->_model->getById('alumnos', $datos[$index]['id_alumno']);
            $datos[$index]['dni'] = $alumno['dni'];
            
            $datos[$index]['nombre'] = $this->getNombreApellido($alumno);
//                    capitalizar($alumno['nombre'] . ' ' . $alumno['apellidos']);

            //fechas            
            $tiempoInicio = $datos[$index]['fecha_inicio'];
            $tiempoFin = $datos[$index]['fecha_fin'];


            $hoy = date('Y-m-d');
            $diaInicio = substr($tiempoInicio, 0, 10);

            if ($hoy == $diaInicio) { //Es de hoy, poner horas
//                puty(__METHOD__);
                $f_temp = date('Y-m-d', strtotime($diaInicio));
                $datos[$index]['fecha_inicio'] = date('H:i', strtotime($tiempoInicio));
            } else { //poner fecha y duración
//                $fechaInicio = date('Y-m-d',$tiempoInicio);
                $datos[$index]['fecha_inicio'] = date('H:i', strtotime($tiempoInicio));
                $datos[$index]['fecha_inicio'] .= " &mdash; " . FechaHora::fechaCorta($diaInicio, false);
            }
//                if ($datos[$index]['fecha_fin']) {
//                    $horaFin = date('H:i', strtotime($datos[$index]['fecha_fin']));
//                    $f_temp = date('Y-m-d', strtotime($datos[$index]['fecha_fin']));
//                    $datos[$index]['fecha_fin'] = $horaFin . " &mdash; " . FechaHora::fechaCorta($f_temp, FALSE);
//                }

            if ($tiempoFin) {
//                $datos[$index]['fecha_fin'] = date('H:i', strtotime($tiempoFin));
                $delta = strtotime($tiempoFin) - strtotime($tiempoInicio);
                $datos[$index]['delta'] = FechaHora::pasarATiempo($delta);
            }
        }

        return $datos;
    }

    private function _getTitulo($centro)
    {
        $nCentro = null;

        if ($centro == 0 && (Session::esAdmin() || Session::esEspecial())) { //admin sin centro seleccionado
            $nCentro = " &mdash; Vista de Administrador";
        } elseif ($centro != 0) { //user sin centro asignado
            $nCentro = " &mdash; " . $this->_model->getNameById('centros', $centro);
        }

        $titulo = 'Acceso libre';
        $titulo .= "<small>";
        $titulo .= $nCentro;
        $titulo .= " </small>";

        return $titulo;
    }

    private function _comprobar_dni($dni)
    {
        $campos = array('dni' => $dni);
        return $this->_model->getIdByDni($dni);
//        return $this->_model->existeRegistro('alumnos', $campos);
    }

    private function _comprobarDatosAlumno()
    {
        $err = null;
//        puty(__METHOD__);

        if (!$this->getSql('nombre') || !$this->getSql('apellidos')) {
            $err = 'Debe introducir, al menos,  el nombre y los apellidos del alumno';
        } elseif (!datecheck($this->getPostParam('fechaNac'))) {
//            $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fechaNac');
        } elseif (!array_key_exists('sexo', $_POST)) {
//            $err = "Seleccione Hombre o Mujer";
        }

        if ($err) {
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Para poner los equipos de lso centros correspondientes
     */
//    public function cambiarEquipos()
//    {
//        $acceso = $this->_model->getAll('acceso_libre','parent');
//        
//        for ($index = 0; $index < count($acceso); $index++) {
//            //Mirar el centro
//            $id_centro = $acceso[$index]['id_centro'];
//            $centro = $this->_model->getNameById('centros',$id_centro);
//            
//            //sacar los equipos del centro
//            $sql = "SELECT id FROM tc30_equipos WHERE id_centro={$id_centro}";
//            $equipos = $this->_model->getSQL($sql);
//            
//            $randEquipo = $equipos[rand(0, count($equipos)-1)]['id'];
//            
//            $table = 'tc30_acceso_libre';
//            $campos = array('id_equipo'=>$randEquipo);
//            $this->_model->editarRegistro($table, $acceso[$index]['id'],  $campos);
//            
//        }
//    }
}
