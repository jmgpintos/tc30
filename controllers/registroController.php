<?php

class registroController extends Controller {

  protected $_modulo = 'registro';

  public function __construct() {
    parent::__construct();

    $this->_model = $this->loadModel($this->_modulo);
    $this->_table = 'usuarios';
  }

  public function index() {
    if (Session::get('autenticado')) {
      if (!Session::esAdmin())
        $this->redireccionar();
    }

    $this->_view->assign('titulo', 'Registro');

    if ($this->getInt('enviar') == 1) {
      $this->_view->assign('datos', $_POST);

      if (!$this->comprobar_datos()) {
        $this->_view->renderizar_template('index', $this->_modulo);
        exit;
      }
      if ($this->_model->registrarUsuario(
                      $this->getSql('nombre'), $this->getSql('apellidos'), $this->getAlphaNum('usuario'), $this->getSql('password'), $this->getPostParam('email'), $this->getPostParam('telefono')
              )) {

        $this->_view->assign('datos', false);
        Session::set('mensaje', '<strong>Registro completado</strong><hr/><div class="text-center">Espere a la activaci&oacute;n del usuario para iniciar sesi&oacute;n</div>');
        $this->_view->assign('_mensaje', 'Registro completado');
      } else {
        Session::set('error', 'Se ha producido un error al registrar el usuario');
        $this->_view->assign('_error', 'Registro no efectuado');
      }
      $this->redireccionar(login . '/index/');
    }

    $this->_view->renderizar_template('index', $this->_modulo);
  }

  public function editar($id) {
    Session::acceso_a_perfil($id);

    $this->_view->titulo = 'Perfil de usuario';
    $this->_view->_error = null;
    $this->_view->setJs(array($this->_modulo));

    $this->_view->datos = $this->_model->getById($this->_table, $id);
    $this->_view->renderizar('perfil', $this->_modulo);
  }

  public function comprobar_datos() {
    $err = null;

    if (!$this->validarSignPW($this->getPostParam('signpw'))) {
      $err = "Clave de registro incorrecta";
    } elseif (!$this->getSql('nombre')) {
      $err = 'Debe introducir su nombre';
    } elseif (!$this->getAlphaNum('usuario')) {
      $err = 'Debe introducir su nombre de usuario';
    } elseif ($this->_model->verificarUsuario($this->getAlphaNum('usuario'))) {
      $err = 'El usuario <strong>' . $this->getAlphaNum('usuario') . '</strong> ya existe';
    } elseif (!$this->getSql('password')) {
      $err = 'Debe introducir una contrase&ntilde;a';
    } elseif ($this->getPostParam('password') != $this->getPostParam('password_again')) {
      $err = 'Las contrase&ntilde;as no coinciden';
    } elseif (!$this->validarEmail($this->getPostParam('email'))) {
      $err = 'La dirección de email es inv&aacute;lida';
    } elseif ($this->_model->verificarEmail($this->getPostParam('email'))) {
      $err = 'Esta dirección de correo ya está registrada';
    } elseif (!$this->validarTelefono($this->getPostParam('telefono'))) {
      $err = 'El n&uacute;mero de tel&eacute;fono es inv&aacute;lido';
    }

    if ($err) {
      $this->_view->assign('_error', $err);
      return false;
    } else {
      return true;
    }
  }

}
