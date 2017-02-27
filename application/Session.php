<?php

class Session {

    const ROLE_GUEST = 0;
    const ROLE_AULA_INNOVA = 22;
    const ROLE_USER = 33;
    const ROLE_SPECIAL = 77;
    const ROLE_ADMIN = 99;

    public static function init()
    {
        session_start();

        if (Session::esAdmin() || DEBUG) {
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }

        Session::set('mostrar_errores', ini_get('display_errors') ? 'true' : 'false');
    }

    /**
     * Borrar la variable $_SESSION[$clave]
     * 
     * @param string $clave
     */
    public static function destroy($clave = false)
    {
        if ($clave) {
            if (is_array($clave)) {
                foreach ($clave as $k) {
                    if (isset($_SESSION[$k])) {
                        unset($_SESSION[$k]);
                    }
                }
            } else {
                if (isset($_SESSION[$clave])) {
                    unset($_SESSION[$clave]);
                }
            }
        } else {
            session_destroy();
        }
    }

    /**
     * Establece la variable $_SESSION[$clave] = $valor
     * 
     * @param String $clave
     * @param type $valor
     */
    public static function set($clave, $valor)
    {
        if (!empty($clave)) {
            $_SESSION[$clave] = $valor;
        }
    }

    /**
     * Devuelve el valor de la variable $_SESSION[$clave]
     * 
     * @param String $clave
     * @return $SESSION[$clave] o FALSE si no está definida la variable de sesión
     */
    public static function get($clave = false)
    {
        if (!$clave) {
            ksort($_SESSION);
            return $_SESSION;
        } elseif (isset($_SESSION[$clave])) {
            return $_SESSION[$clave];
        } else {
            return false;
        }
    }

    /**
     * @return int Devuelve el id de usuario conectado actualmente -> $_SESSION['id_usuario']
     */
    public static function getId()
    {
        return Session::get('id_usuario');
    }

    /**
     * 
     * @param int $id id de usuario
     * @return boolean TRUE si el usuario tiene el rol de admin(3)
     */
    public static function esAdmin()
    {

        return self::getLevel(self::get('level')) == self::ROLE_ADMIN;
    }

    /**
     * 
     * @param int $id id de usuario
     * @return boolean TRUE si el usuario tiene el rol de especial o mayor
     */
    public static function esEspecial()
    {

        return self::getLevel(self::get('level')) >= self::ROLE_SPECIAL;
    }

    /**
     * Devuelve el entero correspondiente al nivel del usuario
     * 
     * @param String $level
     * @return int
     * @throws Exception
     */
    public static function getLevel($level = 'invitado')
    {
//        puty($level);
        if(is_numeric($level)){
            return $level;
        }
        if (empty($level)) {
            $level = 'invitado';
        }
        $role['admin'] = self::ROLE_ADMIN;
        $role['especial'] = self::ROLE_SPECIAL;
        $role['usuario'] = self::ROLE_USER;
        $role['aula_innova'] = self::ROLE_AULA_INNOVA;
        $role['invitado'] = self::ROLE_GUEST;
        

        if (!array_key_exists($level, $role)) {
            throw new Exception('Error de acceso. Nivel de usuario: ' . $level);
        } else {
            return $role[$level];
        }
    }
    
    public static function getUserLevel() {
      return self::getLevel(self::get('level'));
    }

    /**
     * Redirige a la página de error si el usuario no puede acceder al perfil pedido
     * 
     * @param int $id id del usuario conectado actualmente
     */
    public static function acceso_a_perfil($id)
    {
        $id = (int) $id;
        if (Session::getLevel(Session::get('level')) <= Session::getLevel('usuario')) {
            if (Session::getId() != $id) {
                header('location:' . BASE_URL . 'error/access/5050');
            }
        }
    }

    /**
     * Determina si el usuario tiene nivel suficiente para acceder y mantiene la sesión activa
     * 
     * @param String $level
     */
    public static function acceso($level)
    {
        if (!Session::get('autenticado')) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        Session::tiempo(); //actualiza tiempo para mantener sesión activa

        if (Session::getLevel($level) > Session::getLevel(Session::get('level'))) {
            Session::destroy('nombre_borrado');

            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }

    /**
     * Determina el acceso según una lista de roles y mantiene la sesión activa
     * 
     * @param array $level
     * @param type $noAdmin
     * @return type
     */
    public static function accesoEstricto(array $level, $noAdmin = false)
    {
        if (!Session::get('autenticado')) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        Session::tiempo(); //actualiza tiempo para mantener sesión activa

        if ($noAdmin == false && Session::get('level') == 'admin') {
            return;
        }

        if (count($level)) {
            if (in_array(Session::get('level'), $level)) {
                return;
            }
            header('location:' . BASE_URL . 'error/access/5050');
        }
    }

    /**
     * Determina si un fragmento de código html se muestra o no según el nivel de acceso del usuario
     * 
     * @param String $level
     * @return boolean
     */
    public static function accesoView($level)
    {
        if (!Session::get('autenticado')) {
            return false;
        }

        if (Session::getLevel($level) > Session::getLevel(Session::get('level'))) {
            return false;
        }
        return true;
    }

    public static function accesoViewEstricto(array $level, $noAdmin = false)
    {
        if (!Session::get('autenticado')) {
            return false;
        }

        if ($noAdmin == false && Session::get('level') == 'admin') {
            return true;
        }

        if (count($level)) {
            if (in_array(Session::get('level'), $level)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Actualiza la variable $_SESSION['tiempo']
     * 
     * Esta función es llamada por @see acceso y @see accesoEstricto, por eso es necesario establecer el acceso en TODOS los módulos, aunque el acceso esté permitido a todos los usuarios. 
     * 
     * @return type
     * @throws Exception
     */
    public static function tiempo()
    {
        if (!Session::get('tiempo') || !defined('SESSION_TIME')) {
            throw new Exception('No se ha definido el tiempo de sesión');
        }
        if (SESSION_TIME == 0) {
            return;
        }
        $modelo = new Model();
        if(!$modelo->getById('usuarios', session::getId())){
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/5050');
        }

        if (time() - Session::get('tiempo') > (SESSION_TIME) * 60) {
            $pilaLlamadas = Session::get('pilaLlamadas');

            Session::destroy();
            Session::init();

            Session::set('destino', $pilaLlamadas[0]);

            header('location:' . BASE_URL . 'error/access/8080');
        } else {
            Session::set('tiempo', time());
            Model::cambiarUltimoAcceso(Session::get('id_usuario'));
        }
    }

}
