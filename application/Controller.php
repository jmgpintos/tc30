<?php

abstract class Controller {

    protected $_view;
    protected $_model;
    protected $_error;
    protected $_mensaje;
    protected $_table;
    protected $_modulo;

    public function __construct()
    {
        $this->_view = new View(new Request(FALSE));
        $this->_mensaje = Session::get('_mensaje');
        $this->_error = Session::get('_error');
    }

    abstract public function index();

    protected function loadModel($modelo)
    {
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

        if (is_readable($rutaModelo)) {
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        } else {
            throw new Exception("Modelo <strong>$modelo</strong> no encontrado");
        }
    }

    public function eliminar($id, $controlador = '', $acceso = 'especial', $nombrePagina='pagina')
    {
//        vardumpy(func_get_args());
//        puty($acceso);
        Session::acceso($acceso);
        $pagina = Session::get($nombrePagina); //página del listado que se visualiza

        $reg_borrado = Session::get('nombre_borrado');

        if (!$this->filtrarInt($id)) {
            $this->redireccionar($this->_modulo);
            exit;
        }
        if (!empty($controlador)) {
            $url = BASE_URL . $controlador . '/ver/' . $id;
        }

        $error = "<div class='text-center'>Error al borrar ";
        if (!$this->_model->getById($this->_table, ($this->filtrarInt($id)))) {
            $error .= "no se encuentra el registro.";
            $error .= "</div>";
            $this->setError($error);
            Session::destroy('nombre_borrado');
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
            exit;
        }

        if (!$this->_model->eliminarRegistro($this->_table, ($this->filtrarInt($id)))) {
            Session::destroy('nombre_borrado');
            if (!empty($reg_borrado)) {
                $error .= " el registro correspondiente a <a href='" . $url . "'><strong>" . $reg_borrado . "</strong></a>";
            }
            $error .= "</div>";
            $error .= "<div class='text-center'>Es posible que haya registros en otras tablas que dependan de este.</div>";
            $this->setError($error);
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
            exit;
        } else {
            $this->redireccionar($this->_modulo . '/index/' . $pagina);
        }
    }

    protected function getLibrary($libreria)
    {
        $rutaLibreria = LIB_PATH . $libreria . '.php';

        if (is_readable($rutaLibreria)) {
            require_once $rutaLibreria;
        } else {
            throw new Exception('Librería ' . $libreria . ' no encontrada');
        }
    }

    protected function getTexto($clave)
    {
        $k = filter_input(INPUT_POST, $clave);
        if (!empty($k)) {
            $_POST[$clave] = htmlspecialchars($k, ENT_QUOTES);
            return filter_input(INPUT_POST, $clave);
        }
        return '';
    }

    protected function getInt($clave)
    {
        $k = filter_input(INPUT_POST, $clave);
        if (!empty($k)) {
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return filter_input(INPUT_POST, $clave);
        }
        return 0;
    }

    protected function redireccionar($ruta = false)
    {
        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit;
        } else {
            header('location:' . BASE_URL);
            exit;
        }
    }

    protected function filtrarInt($entero)
    {
        $int = (int) $entero;

        if (is_int($int)) {
            return $int;
        } else {
            return 0;
        }
    }

    protected function getPostParam($clave)
    {
        $k = filter_input(INPUT_POST, $clave);
        return trim($k);
    }

    protected function getSql($clave)
    {
        $k = filter_input(INPUT_POST, $clave);
        if (!empty($k)) {
            $_POST[$clave] = strip_tags($k);

            if (!get_magic_quotes_gpc()) {
                
            }
            $k = filter_input(INPUT_POST, $clave);
            return rtrim($k);
        }
    }

    protected function getAlphaNum($clave)
    {
        $k = filter_input(INPUT_POST, $clave);
        if (!empty($k)) {
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_]/i', '', $k);

            filter_input(INPUT_POST, $clave);
            return trim($k);
        }
    }

    public function validarEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function validarTelefono($telefono)
    {
        if (!filter_var($telefono, FILTER_VALIDATE_INT) || strlen($telefono) != 9) {
            return false;
        }
        return true;
    }

    public function validarSignPW($signPW)
    {
//        put(SIGNPW);
//        puty(Hash::getHash('sha1', $signPW, HASH_KEY));
        if (SIGNPW != (Hash::getHash('sha1', $signPW, HASH_KEY))) {
            return false;
        }
        return true;
    }

    /**
     * Hace que se muestre la página de error con el error_no indicado en $error
     * @param int $error
     */
    public function saltar_error($error = false, $item1 = false, $item2 = FALSE)
    {
        if ($error) {
            $error = (int) $error;
            if ($item2) {
                $this->redireccionar('error/access/' . $error . '/' . $item1 . '/' . $item2);
                exit;
            }
            if ($item1) {
                $this->redireccionar('error/access/' . $error . '/' . $item1);
                exit;
            }
            $this->redireccionar('error/access/' . $error);
        }
    }

    /**
     * Se asegura de que $pagina sea un entero
     * 
     * @param type $pagina
     * @return int|bool
     * 
     * 
     * TODO: pasarlo a la clase Controller
     */
    public function filtrar_pagina($pagina)
    {
        if (!$this->filtrarInt($pagina)) {
            $pagina = false;
        } else {
            $pagina = (int) $pagina;
        }
        return $pagina;
    }

    /**
     * Asigna los mensajes de error o éxito a la plantilla de la vista
     * y los borra de las variables de sesión
     * Los mensajes globales van por variables de session (mensaje y error)
     * Los mensajes privados van por atributo de clase ($this->_mensaje y $this->_error)
     * 
     */
    public function asignar_mensajes()
    {
        if (!empty($this->_mensaje)) {
            $_mensaje = $this->_mensaje;
            $this->_view->assign('_mensaje', $_mensaje);
        } else {
            $_mensaje = Session::get('_mensaje');
            if (!empty($_mensaje)) {
                $this->_view->assign('_mensaje', $_mensaje);
            }
        }

        if (!empty($this->_error)) {
            $_error = $this->_error;
            $this->_view->assign('_error', $_error);
        } else {

            $_error = Session::get('_error');
            if (!empty($_error)) {
                $this->_view->assign('_error', $_error);
            }
        }

        Session::destroy('_mensaje');
        Session::destroy('_error');

        $s = Session::get('error');
        if (!empty($s)) {
            $this->_view->assign('error', Session::get('error'));
        }

        $s = Session::get('mensaje');
        if (!empty($s)) {
            $this->_view->assign('mensaje', Session::get('mensaje'));
        }

        Session::destroy('error');
        Session::destroy('mensaje');

//        puty($this->_mensaje);
//        $this->_view->assign('mensaje', $this->mensaje ? $this->mensaje : null);
//        $this->_view->assign('error', $this->error ? $this->error : null);
//        Session::destroy('mensaje');
//        Session::destroy('error');
    }

    public function setMensajePrivado($mensaje)
    {
        Session::set(_mensaje, $mensaje);
    }

    public function setErrorPrivado($error)
    {
        Session::set(_error, $error);
    }

    public function setMensaje($mensaje)
    {
        Session::set('mensaje', $mensaje);
    }

    public function setError($error)
    {
        Session::set('error', $error);
    }

    /**
     * Devuelve array para colocar en combo
     * 
     * @param string $tabla Tabla de la que se leen los datos
     * @param string $primeraOpcion Opción para el primer valor del combo (devuelve valor nulo)
     * 
     * @return array
     */
    protected function pasarTablaACombo($tabla, $primeraOpcion = '', $hayPrimeraOpcion = TRUE)
    {
        if ($tabla == 'usuarios') {
            $r = $this->_model->getTablaProfesores();
            for ($i = 0; $i < count($r); $i++) {
                $r[$i]['nombre'] = $this->getNombreApellido($r[$i]['nombre'], $r[$i]['apellidos']);
                $r[$i]['apellidos'] = null;
            }
        }elseif ($tabla == 'aula_responsables') {
            $r = $this->_model->getTablaResponsables();
            for ($i = 0; $i < count($r); $i++) {
                $r[$i]['nombre'] = $this->getNombreApellido($r[$i]['nombre'], $r[$i]['apellidos']);
                $r[$i]['apellidos'] = null;
            }
        } else {
            $r = $this->_model->getTabla($tabla, 'nombre');
        }
        if ($hayPrimeraOpcion) {
            array_unshift($r, array(
                'id' => '0',
                'nombre' => $primeraOpcion));
        }
        return $r;
    }

    /**
     * Devuelve array para colocar en combo
     * 
     * @param string $tabla Tabla de la que se leen los datos
     * @param string $primeraOpcion Opción para el primer valor del combo (devuelve valor nulo)
     * 
     * @return array
     */
    protected function pasarArrayACombo($array, $primeraOpcion = '', $hayPrimeraOpcion = TRUE)
    {
        $r = $array;
        if ($hayPrimeraOpcion) {
            array_unshift($r, array(
                'id' => '0',
                'nombre' => $primeraOpcion));
        }
        return $r;
    }

    /**
     * Volver a la página anterior (evita el mensaje de actualizar datos)
     * 
     * @param string $modulo A dónde se vuelve (va al método index [listado])
     * @param int $pag Página del listado a la que vuelve
     */
    public function volver($modulo, $pag = FALSE)
    {

        if (!$pag) {
            $pag = Session::get('pagina');
        }

        $this->redireccionar($modulo . '/index/' . $pag);
    }

    /**
     * Determina si la página de la que viene la petición es del mismo módulo que la actual
     * 
     * @return boolean
     */
    public function vieneDeFuera()
    {
        $sw = stripos($_SERVER['HTTP_REFERER'], $this->_modulo);

        if (!$sw) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Devuelve "Apellidos, Nombre"
     * 
     * @param string,array $nombre
     * @param string $apellidos
     * @return string
     */
    public function getNombreApellido($nombre = false, $apellidos = false)
    {
        if (is_array($nombre)) {
            $arr = $nombre;
            $nombre = $arr['nombre'];
            $apellidos = $arr['apellidos'];
        }

        $r = false;
        if ($apellidos) {
            $r .= capitalizar($apellidos);
            if ($nombre) {
                $r .= ', ' . capitalizar($nombre);
            }
        } elseif ($nombre) {
            $r .= capitalizar($nombre);
        }

        return $r ? $r : '----';
    }

    protected function _definirAccesoAula_()
    {
        Session::accesoEstricto(array('aula_innova', 'especial'));
    }

    
        /**** MÉTODOS PARA BUSCAR EN LOS LISTADOS (index) *******/
    
    /**
     * Código del botón buscar.
     * Lee el dato de $_POST, realiza la búsqueda y pasa la sentencia SQL a resultados_busqueda()
     */
    protected function _buscar_()
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
     * Código para el botón "ver todo" (en búsqueda)
     */
    public function ver_todo()
    {
        Session::destroy('sql');
        Session::destroy('buscar');
        $this->index(Session::get('pagina'));
    }
    
    /*** FIN DE METODOS PARA BUSCAR ***/

}
