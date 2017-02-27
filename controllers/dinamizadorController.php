<?php

class dinamizadorController extends Controller {

    protected $_table = 'usuarios';
    protected $_modulo = 'dinamizador';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('dinamizador');
    }

    /*
     * Listado de dinamizadores
     */

    public function index($pagina = 1)
    {
        Session::acceso('usuario');

        if (!$this->filtrarInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }

        $this->_view->setJs(array('confirmarBorrar'));

        if (Session::get('nombre_borrado') && $this->_error == null) {
            $nombre_borrado = Session::get('nombre_borrado');
            Session::destroy('nombre_borrado');
            $this->_mensaje = "Se ha borrado el registro correspondiente a <strong>" . $nombre_borrado . "</strong>";
        }

        $this->getLibrary('paginador');
        $paginador = new Paginador();

        $this->_view->assign('pagina', $pagina);
        Session::set('pagina', $pagina);

        $this->asignar_mensajes();

        if (!Session::esEspecial()) {
            //No ver usuarios inactivos
            $datos = $this->_model->getActivos();
        } else {
            $datos = $this->_model->getAll($this->_table);
        }
        $datos = $this->_formatoDatos($datos);
//        vardumpy($datos);


        $this->_view->assign('controlador', $this->_modulo);
        $this->_view->assign('posts', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
        $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index'));
        $this->_view->assign('titulo', 'Listado de dinamizadores');
        $this->_view->assign('cuenta', count($datos));

        $this->_view->renderizar_template('index', $this->_modulo);
    }

    /**
     * Crear dinamizador
     */
    public function nuevo()
    {
        Session::acceso('especial');

        $this->_view->assign('titulo', 'Nuevo dinamizador');

        $this->_view->setJs(array('nuevo'));

        $centros = $this->pasarTablaACombo('centros', "Sin centro asignado");
        $this->_view->assign('centros', $centros);

        if ($this->getInt('guardar') == 1) {
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos('nuevo')) {
                $this->_view->renderizar_template('nuevo', $this->_modulo);
                exit;
            }

            $imagen = '';
            $this->getLibrary('upload' . DS . 'class.upload');
            $ruta = ROOT . 'public' . DS . 'img' . DS . 'post' . DS;


            if (isset($_FILES['imagen']['name'])) {
                $upload = $this->subir_imagen();

                if ($upload->processed) {
                    $imagen = $upload->file_dst_name;
                    $thumb = new upload($upload->file_dst_pathname, 'es_ES');
                    $thumb_list = new upload($upload->file_dst_pathname, 'es_ES');
                    $thumb->image_resize = $thumb_list->image_resize = true;
                    $thumb->image_ratio = $thumb_list->image_ratio = true;
                    $thumb_list->image_x = 120;
                    $thumb->image_x = 250;
//                    $thumb->image_y = 70;
                    $thumb->file_name_body_pre = 'thumb_';
                    $thumb_list->file_name_body_pre = 'thumb_ls_';
                    $thumb->process($ruta . 'thumb' . DS);
                    $thumb_list->process($ruta . 'thumb' . DS);
//                    if (!$thumb->processed) {
//                        $this->_view->assign('error', $thumb->error);
//                        $this->_view->renderizar_template('nuevo', $this->_modulo);
//                        exit;
//                    }
                } else {
                    $this->_view->assign('error', $upload->error);
                    $this->_view->renderizar_template('nuevo', $this->_modulo);
                    exit;
                }
            }

            $this->_model->insertarRegistro(
                    $this->_table, array(
                ':nombre' => $this->getPostParam('nombre'),
                ':apellidos' => $this->getPostParam('apellidos'),
                ':usuario' => $this->getPostParam('usuario'),
                ':password' => Hash::getHash('sha1', $this->getPostParam('password'), HASH_KEY),
                ':email' => $this->getPostParam('email'),
                ':telefono' => $this->getPostParam('telefono'),
                ':id_centro' => $this->getInt('id_centro'),
                ':role' => DEFAULT_ROLE,
                ':estado' => 0,
                ':fecha' => date('Y-m-d H:i:s'),
                ':ultimo_acceso' => null,
                ':id_centro' => $this->getInt('id_centro')
                    )
            );

            if (!$this->_model->existeRegistro(
                            $this->_table, array('usuario' => $this->getAlphaNum('usuario'))
                    )) {
                $this->_view->assign('_error', 'Error al registrar el usuario');
                $this->_view->renderizar_template('index', $this->_modulo);
                exit;
            }

            $this->_view->assign('datos', false);
            Session::set('mensaje', 'Se ha creado un nuevo registro para <strong>'
                    . $this->getPostParam('apellidos') . ', ' . $this->getPostParam('nombre') . '</strong>');

            $this->redireccionar('dinamizador');
        }

        $this->_view->renderizar_template('nuevo', $this->_modulo);
    }

    /**
     * Editar dinamizador con id = $id
     * @param int $idUsuario
     */
    public function editar($idUsuario)
    {

        //Si tiene nivel suficiente y no es su perfil
        if (Session::esEspecial(Session::get('id')) && Session::getId() != $idUsuario) {
            //Editar perfil de otro usuario
            $this->editarPerfilDeOtroUsuario($idUsuario);
            exit;
        }

        //editar perfil propio
        Session::acceso_a_perfil($idUsuario);
        if (!$this->filtrarInt($idUsuario)) {
            $this->redireccionar($this->dinamizador);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($idUsuario))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo);
            exit;
        }

        $this->_view->setJs(array('tab'));

        $this->asignar_mensajes();

        $this->_view->assign('titulo', "Editar dinamizador");
//        $this->_view->setJs(array('nuevo', 'file_input', 'sexyradiobuttons','tab'));

        if ($this->getInt('guardar_perfil') == 1) {
            $this->_guardarPerfil($idUsuario);
        } elseif ($this->getInt('guardar_pw') == 1) {
            $this->_guardarPassword($idUsuario);
        }
//        vardump($_POST);
//        vardump($this->_model->getById($this->_table, $this->filtrarInt($idUsuario)));

        $this->_view->assign('datos', $this->_model->getById($this->_table, $this->filtrarInt($idUsuario)));
        $this->_view->assign('centros', $this->pasarTablaACombo('centros', 'Sin centro asociado'));

        $this->_view->renderizar_template('editar', $this->_modulo);
    }

    public function editarPerfilDeOtroUsuario($id)
    {

        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->dinamizador);
        }

        if (!$this->_model->getById($this->_table, $this->filtrarInt($id))) {
            $_metodo = __METHOD__;
            $this->redireccionar('error/access/804/' . $_metodo);
            exit;
        }

        $this->asignar_mensajes();

        $centros = $this->pasarTablaACombo('centros', "Sin centro asignado");
        $this->_view->assign('centros', $centros);
        $this->_view->assign('controlador', $this->_modulo);

        $this->_view->assign('titulo', "Editar dinamizador");
        $this->_view->setJs(array('nuevo', 'file_input', 'sexyradiobuttons', 'reset_pw'));

        if ($this->getInt('guardar') == 1) {
            vardump($_POST);
            $this->_view->assign('datos', $_POST);

            if (!$this->_comprobarDatos($id, 'editar')) {
//            puty(__METHOD__);
                $this->_view->renderizar_template('perfil', $this->_modulo);
                exit;
            }
            $this->_model->editarRegistro(
                    $this->_table, $id, array(
                ':nombre' => $this->getPostParam('nombre'),
                ':apellidos' => $this->getPostParam('apellidos'),
                ':usuario' => $this->getPostParam('usuario'),
                ':email' => $this->getPostParam('email'),
                ':telefono' => $this->getPostParam('telefono'),
                ':id_centro' => $this->getInt('id_centro'),
                ':role' => $this->getPostParam('role'),
                ':estado' => $this->getPostParam('estado') == 'on' ? 1 : 0,
                    )
            );

            if ($id == Session::getId()) {
                Session::set('nombre', $this->getNombreApellido($this->getPostParam('nombre', $this->getPostParam('apellidos'))));
                Session::set('level', $this->getPostParam('role'));
            }

            $url = BASE_URL . $this->_modulo . '/editar/' . $id;

            //Comprobar si hay más de un dinamizador asginado al mismo centro

            if ($this->_model->dinamizadoresEnCentro($this->getInt('id_centro')) > 1) {
                $cuenta = $this->_model->dinamizadoresEnCentro($this->getInt('id_centro'));
                $centro = $this->_model->getNameById('centros', $this->getInt('id_centro'));
                $aviso = "Hay más de un dinamizador ({$cuenta}) asignados al centro <strong>{$centro}</strong>";
                $aviso .="<hr><div class='text-center'><small>No es necesario corregir si es correcto</small></div>";
                Session::set('error', $aviso);
            }

            Session::set('mensaje', 'El registro correspondiente a <strong><a href="' . $url . '">' 
                    . $this->getNombreApellido($_POST) 
                    . '</a></strong> ha sido modificado');
            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));

//            Session::set('mensaje', 'El registro correspondiente a <a href=<strong>' . $this->getPostParam('nombre') . '</strong> ha sido modificado');
//            $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
        }

        $this->_view->assign('datos', $this->_model->getById($this->_table, $this->filtrarInt($id)));

        $this->_view->renderizar_template('perfil', $this->_modulo);
    }

    /**
     * Eliminar dinamizador con id = $id
     * @param int $id
     */
    public function eliminar($id, $controlador = false, $acceso = false, $pagina=false)
    {
        $dinamizador = $this->_model->getById($this->_table, $id);
        Session::set('nombre_borrado', $dinamizador['nombre']);
        parent::eliminar($id, $this->_modulo);
    }

    /*     * *********************************************************
     * 
     * 
     *          FUNCIONES PRIVADAS DEL CONTROLADOR Dinamizador
     * 
     * 
     * 
     * ********************************************************** */

    /**
     * Comprobar que los datos introducidos en los formularios son correctos
     * 
     * @param string $accion 'nuevo'|'editar' para saber qué campos se deben validar
     * @return boolean
     * 
     */
    private function _comprobarDatos($idUsuario, $accion = false)
    {
        $err = null;
        //Comprobaciones comunes
        if (!$this->getSql('usuario')) {
            $err = 'Debe introducir el nombre de usuario';
        } elseif (!$this->getSql('nombre')) {
            $err = 'Debe introducir el nombre del dinamizador';
        } elseif (!$this->validarEmail($this->getPostParam('email'))) {
            $err = 'La dirección de email es inv&aacute;lida';
        } elseif (!validar_telefono($this->getTexto('telefono'))) {
            $err = 'Debe introducir un n&uacutemero de tel&eacute;fono correcto';
        }

        //comprobaciones para cada caso
        if (is_null($err)) {
            if ($accion === 'editar') {
                $err = $this->_comprobarDatosEditar($idUsuario);
            } elseif ($accion === 'nuevo') {
                $err = $this->_comprobarDatosNuevo();
            }
        }

        if ($err) {
            $this->_view->assign('_errorNum', 1);
            $this->_view->assign('error', $err);
            return false;
        } else {
            return true;
        }
    }

    /**
     * 
     * @return string Texto con el error o NULL
     */
    private function _comprobarDatosNuevo()
    {
        $err = null;

        if ($this->_model->existeRegistro(
                        $this->_table, array(
                    'usuario' => $this->getTexto('usuario'))
                )) {
            $err = 'El usuario <em><strong>' . $this->getAlphaNum('usuario') . '</strong></em> ya existe';
        } elseif (!$this->getSql('password')) {
            $err = 'Debe introducir una contrase&ntilde;a';
        } elseif ($this->getPostParam('password') != $this->getPostParam('password_again')) {
            $err = 'Las contrase&ntilde;as no coinciden';
        } elseif ($this->_model->existeRegistro(
                        $this->_table, array(
                    'email' => $this->getTexto('email'))
                )) {
            $err = 'Esta direcci&oacute;n de correo ya est&aacute; registrada';
        }

        return $err;
    }

    /**
     * 
     * @param int $idUsuario
     * @return string Texto con el error o NULL
     */
    private function _comprobarDatosEditar($idUsuario)
    {
        $err = null;
//        vardumpy($_POST);
        //comprobar que no esté repetido $this->getPostParam('email')
        if ($this->_model->usuarioRepetido($idUsuario, $this->getAlphaNum('usuario'))) {

            $err = 'Este nombre de usuario ya está siendo utilizado  por otro usuario';
        } elseif ($this->_model->emailRepetido($idUsuario, $this->getPostParam('email'))) {
            $err = 'Este email ya lo está utilizando otro usuario';
        }
        return $err;
    }

//    private function _leerCentros($primeraOpcion = "")
//    {
//        $centros = $this->_model->getCentros();
//        array_unshift($centros, array(
//            'id' => '0',
//            'nombre' => $primeraOpcion));
//        return $centros;
//    }
//    private function _refrescarDatos()
//    {
//        Session::set('nombre', $this->getPostParam('nombre'));
//        Session::set('level', $this->getPostParam('role'));
//    }

    private function _guardarPerfil($idUsuario)
    {

        $this->_view->assign('datos', $_POST);  //Solo datos de user
//        vardumpy($_POST); 

        if (!$this->_comprobarDatos($idUsuario, 'editar')) {
            $this->_view->renderizar_template('editar', $this->_modulo);
            exit;
        }

        $campos[':nombre'] = $this->getPostParam('nombre');
        $campos[':apellidos'] = $this->getPostParam('apellidos');
        $campos[':usuario'] = $this->getPostParam('usuario');
        $campos[':email'] = $this->getPostParam('email');
        $campos[':telefono'] = $this->getPostParam('telefono');
        if (Session::esEspecial()) {
            $campos[':id_centro'] = $this->getInt('id_centro');
        }

        $this->_model->editarRegistro($this->_table, $idUsuario, $campos);

        $nombre = $this->getNombreApellido($this->getPostParam('nombre', $this->getPostParam('apellidos')));
        $mensaje = '<div class="text-center">'
                . 'El registro correspondiente a <strong>'
                . $nombre
                . '</strong> ha sido modificado<hr/>'
                . '<a class="btn btn-success" href="' . BASE_URL
                . '">Pulse para continuar</a></div>';
        Session::set('mensaje', $mensaje);

        $this->redireccionar($this->_modulo . '/editar/' . $idUsuario);
    }

    private function _guardarPassword($idUsuario)
    {
        $this->_view->assign('pws', $_POST); //Solo datos de pw

        $p = $this->getPostParam('pw_actual');
        if (!empty($p)) {
            $pwEscrita = Hash::getHash('sha1', $this->getPostParam('pw_actual'), HASH_KEY);
            $pwGuardada = $this->_model->getPassword($idUsuario);

            //Comprobar contraseña actual
            if (!empty($pwEscrita) && $pwEscrita != $pwGuardada) {
                $this->_view->assign('_errorNum', 2);
                $this->_view->assign('_error', "La contrase&ntilde;a actual no es correcta");
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            //Comprobar que los dos campos de contraseña nueva coinciden
            $p = $this->getPostParam('pw_nueva');
            if (empty($p) ||
                    ($this->getPostParam('pw_nueva') != $this->getPostParam('pw_2'))) {
                $this->_view->assign('_errorNum', 2);
                $this->_view->assign('_error', "Las contrase&ntilde;as no coinciden o est&aacute;n vac&iacute;as");
                $this->_view->renderizar_template('editar', $this->_modulo);
                exit;
            }

            //Guardar nueva contraseña
            $campos = array(':password' => Hash::getHash('sha1', $this->getPostParam('pw_nueva'), HASH_KEY));
            $this->_model->editarRegistro('usuarios', $idUsuario, $campos);

            $mensaje = '<div class="text-center">'
                    . 'Contrase&ntilde;a cambiada<hr/>'
                    . '<a class="btn btn-success" href="' . BASE_URL
                    . '">Pulse para continuar</a></div>';
            Session::set('mensaje', $mensaje);

            $this->redireccionar($this->_modulo . '/editar/' . $idUsuario);
        }
    }

    private function _formatoDatos($usuarios)
    {
        for ($i = 0; $i < count($usuarios); $i++) {
            $usuarios[$i]['nombre'] = $this->getNombreApellido($usuarios[$i]);
            $usuarios[$i]['telefono'] = formato_telefono($usuarios[$i]['telefono']);
            $usuarios[$i]['ultimo_acceso'] = date('H:i d/m/y', strtotime($usuarios[$i]['ultimo_acceso']));
        }

        return $usuarios;
    }

    public function resetPW($idUsuario)
    {

        Session::acceso('especial');

        if (!$this->filtrarInt($idUsuario)) {
            $this->_error = "id no encontrado";
            Session::set('error', $this->_error);
            $idUsuario = false;
            exit;
        } else {
            $idUsuario = (int) $idUsuario;
        }

        $usuario = $this->_model->getNameById('usuarios', $idUsuario);

        $nombre = $this->getNombreApellido($usuario);

        if ($this->_model->setDefaultPassword($idUsuario)) {
            $msj = "Contrase&ntilde;a restablecida para el usuario <strong>$nombre</strong>";
            Session::set('mensaje', $msj);
            
        Log::info('password cambiado', array(
            'tabla' => $table,
            'id_usuario' => $idUsuario,
            'pw_anterior' => $pw_anterior)
        );
        
        } else {
            $err = "Error al restablecer contrase&ntilde;a del usuario <strong>$nombre</strong>";
            Session::set('error', $err);
        }

        $this->redireccionar('dinamizador');
    }

    /**
     * Función para crear nuevos dinamizadores automáticamente
     * 
     *                      PARA PRUEBAS
     */
//    public function nuevo_auto()
//    {
//        $this->_model->nuevo_dinamizador_auto();
//        $this->redireccionar($this->_modulo . '/index/' . Session::get('pagina'));
//    }
}
