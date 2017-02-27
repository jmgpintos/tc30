<?php

class loginController extends Controller {

    protected $_model;

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('login');
    }

    public function index($dest = '')
    {
        $destino = $this->_ponerDestino($dest);

        if (Session::get('autenticado')) {
            $this->redireccionar();
        }
//        $this->asignar_mensajes();
        $this->_view->assign('titulo', 'Iniciar sesi&oacuten');

        $s = Session::get('mensaje');
        $this->_view->assign('mensaje', !empty($s) ? Session::get('mensaje') : null);
        Session::destroy('mensaje');
        $this->_view->setJs(array('login'));

        if ($this->getInt('enviar') == 1) {
            $this->_view->assign('datos', $_POST | '');

            if (!$this->getAlphaNum('usuario')) {
                $this->_view->assign('error', 'Debe introducir su nombre de usuario');
                $this->_view->renderizar_template('index', 'login');
                exit;
            }

            if (!$this->getSql('password')) {
                $this->_view->assign('error', 'Debe introducir su password');
                $this->_view->renderizar_template('index', 'login');
                exit;
            }

            $row = $this->_model->getUsuario(
                    $this->getAlphaNum('usuario'), $this->getSql('password')
            );

            if (!$row) { //usuario no existe
                $this->_view->assign('error', 'Usuario y/o password incorrectos');
                $this->_view->renderizar_template('index', 'login');
                exit;
            }

            if ($row['estado'] != 1) {
                Session::set('id_usuario', $row['id']);
                Log::warning(
                        'Intento de conexión de usuario no habilitado: ' . $this->getAlphaNum('usuario'));
                Session::destroy('id_usuario');
                $this->_view->assign('error', 'Este usuario no está habilitado');
                $this->_view->renderizar_template('index', 'login');
                exit;
            }

            Session::set('autenticado', true);
            Session::set('level', $row['role']);
            Session::set('usuario', $row['usuario']);
            Session::set('nombre', $this->getNombreApellido($row['nombre'], $row['apellidos']));
            Session::set('id_usuario', $row['id']);
            Session::set('tiempo', time());


//            $this->_model->editarRegistro('usuarios', $row['id'], array(':ultimo_acceso' => FechaHora::Hoy()));
            $this->_model->cambiarUltimoAcceso($row['id']);
            Log::info('Usuario conectado: ' . Session::get('usuario'));

//            $this->redireccionar('index');
            $this->redireccionar($destino);
        }

        $this->_view->renderizar_template('index', 'login');
    }

    /**
     * Log off. Borrar sesión
     */
    public function cerrar()
    {
        Log::info('Usuario desconectado: ' . Session::get('usuario'));
        Session::destroy();
        $this->redireccionar();
    }

    private function _ponerDestino($destino = '')
    {
        if (empty($destino)) {
            $destino = Session::get('destino');
        }

        if (empty($destino)) {
            $destino = 'index';
        }
        return $destino;
    }


}
