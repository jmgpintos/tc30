<?php

require_once ROOT . 'libs' . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php';

class View extends Smarty {

    private $_controlador;
    private $_js;
    private $_menu;

    public function __construct(Request $peticion)
    {
        parent::__construct();

        $this->_controlador = $peticion->get_controlador();
        $this->_js = array();

        Preferencias::init();
    }

    public function renderizar($vista, $item = false)
    {
        $_menu = $this->getMenu();

        $js = array();

        if (count($this->_js)) {
            $js = $this->_js;
        }

        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_fonts' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/fonts/',
            'menu' => $_menu['menu_left'],
            'menu_right' => $_menu['menu_right'],
            'js' => $js
        );


        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';

        if (is_readable($rutaView)) {
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        } else {
            throw new Exception('Vista <strong>' . $rutaView . '</strong> no encontrada');
        }
    }

    public function renderizar_rss($vista, $contenido)
    {


        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.xml';

        if (is_readable($rutaView)) {
            ob_get_clean();
//            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
            ob_start();
            include_once $rutaView;
            echo $contenido;
            ob_end_flush();
//            include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
        } else {
            throw new Exception('Vista <strong>' . $rutaView . '</strong> no encontrada');
        }
    }

    public function renderizar_template($vista, $item = false)
    {
        $this->template_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS;
        $this->config_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'configs' . DS;
        $this->cache_dir = ROOT . 'tmp' . DS . 'cache' . DS;
        $this->compile_dir = ROOT . 'tmp' . DS . 'template' . DS;

        $_menu = $this->getMenu();
//        var_dump($_menu['menu_left']);exit;
        $js = array();

        if (count($this->_js)) {
            $js = $this->_js;
        }

        $_params = array(
            'footer' => ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.tpl',
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'ruta_fonts' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/fonts/',
            'web_adl' => 'http://agenciadesarrollo.ayto-santander.es/adl/adl.aspx/web/',
            'item' => $item,
            'menu' => $_menu['menu_left'],
            'menu_right' => $_menu['menu_right'],
            'js' => $js,
            'root' => BASE_URL,
            'configs' => array(
                'app_name' => APP_NAME,
                'app_slogan' => APP_SLOGAN,
                'app_company' => APP_COMPANY
            )
        );

        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.tpl';

        if (is_readable($rutaView)) {
            $this->assign('_contenido', $rutaView);
        } else {
//            throw new Exception('Vista <strong>' . $rutaView . '</strong> no encontrada');
            include_once ROOT . 'controllers' . DS . 'errorController.php';
            $e = new errorController;
            $p = str_replace('/', '->', substr($rutaView, strlen(ROOT)));
            $e->saltar_error(404, $p);
        }
        $this->assign('_layoutParams', $_params);
        $this->display('template.tpl');
    }

    public function setJs(array $js, $controlador = '')
    {
        if (empty($controlador)) {
            $controlador = $this->_controlador;
        }

        if (is_array($js) && count($js)) {
            foreach ($js as $v) {
                if ($v == 'initTinyMCE') {
                    $this->_js [] = BASE_URL . 'public/js/tinymce/tinymce.min.js';
                    $this->_js [] = BASE_URL . 'views/' . $controlador . '/js/' . $v . '.js';
                } else {
                    $this->_js [] = BASE_URL . 'views/' . $controlador . '/js/' . $v . '.js';
                }
            }
        } else {
            throw new Exception('Error de js');
        }
    }

    public function getMenu()
    {
        $menu_left = array();

        $submenu_curso = $submenu_admin = null;
        $submenu = $this->getSubMenu();

        if (Session::getUserLevel() == Session::ROLE_AULA_INNOVA) { //Menu para usuario aula_innova
            $menu_left = $this->getMenuInnova();
        } elseif (Session::get('autenticado')) {
            if (Session::esEspecial()) {

                $menu_left[] = array(
                    'id' => 'aula',
                    'titulo' => 'Innova',
                    'enlace' => BASE_URL . 'aula_actividades',
                    'submenu' => $submenu['innova']
                );

                $menu_left[] = array(
                    'id' => 'listados',
                    'titulo' => 'Listados',
                    'enlace' => BASE_URL . 'dinamizador',
                    'submenu' => $submenu['listados']
                );
                $menu_left[] = array(
                    'id' => 'ficha_cursos',
                    'titulo' => 'Cursos',
                    'enlace' => BASE_URL . 'ficha_cursos',
                    'submenu' => $submenu['curso']
                );
            } else {
                $menu_left[] = array(
                    'id' => 'ficha_cursos',
                    'titulo' => 'Cursos',
                    'enlace' => BASE_URL . 'ficha_cursos'
                );
            }

            $menu_left[] = array(
                'id' => 'alumno',
                'titulo' => 'Alumnos',
                'enlace' => BASE_URL . 'alumno'
            );
            if (!Session::esEspecial()) {
                $menu_left[] = array(
                    'id' => 'incidencias',
                    'titulo' => 'Incidencias',
                    'enlace' => BASE_URL . 'incidencias'
                );
                $menu_left[] = array(
                    'id' => 'acceso_libre',
                    'titulo' => 'AccesoLibre',
                    'enlace' => BASE_URL . 'acceso_libre'
                );
            }
        }

        $menu_right = $this->getMenuRight();

        return array('menu_left' => $menu_left, 'menu_right' => $menu_right);
    }

    public function getSubMenu()
    {
//    $submenu = array('curso' => null, 'admin' => null, 'centros' => null, 'dinamizadores' => null);

        $submenu = array();

        $submenu['listados_usuarios'] = array(
            array('id' => 'dinamizador', 'titulo' => 'Lista de Dinamizadores', 'enlace' => BASE_URL . 'dinamizador'),
            array('id' => 'centro', 'titulo' => 'Lista de Centros', 'enlace' => BASE_URL . 'centro')
        );

        $submenu['login'] = array(
            array(
                'id' => 'dinamizador',
                'titulo' => 'Editar Perfil',
                'enlace' => BASE_URL . 'dinamizador/editar/' . Session::get('id_usuario')
            ),
            array(
                'id' => 'login',
                'titulo' => 'Cerrar Sesión',
                'enlace' => BASE_URL . 'login/cerrar'
            )
        );

        if (Session::esEspecial()) {
            $submenu['curso'] = array(
                array('id' => 'ficha_cursos', 'titulo' => 'Lista de Cursos', 'enlace' => BASE_URL . 'ficha_cursos'),
                array('id' => 'ficha_cursos', 'titulo' => 'Nuevo curso', 'enlace' => BASE_URL . 'ficha_cursos/nuevo')
            );
            $submenu['admin'] = array(
                array('id' => 'admin', 'titulo' => 'Cursos', 'enlace' => BASE_URL . 'curso'),
                array('id' => 'admin', 'titulo' => 'Categor&iacute;as', 'enlace' => BASE_URL . 'categorias_cursos'),
                array('id' => 'separador'),
                array('id' => 'admin', 'titulo' => 'Municipios', 'enlace' => BASE_URL . 'municipio'),
                array('id' => 'admin', 'titulo' => 'Ocupaciones', 'enlace' => BASE_URL . 'ocupacion'),
                array('id' => 'admin', 'titulo' => 'Niveles de estudio', 'enlace' => BASE_URL . 'niveles_estudios'),
                array('id' => 'separador'),
                array('id' => 'admin', 'titulo' => 'Incidencias', 'enlace' => BASE_URL . 'incidencias'),
                array('id' => 'admin', 'titulo' => 'Tipos de incidencias', 'enlace' => BASE_URL . 'tipo_incidencias'),
                array('id' => 'separador'),
                array('id' => 'acceso_libre', 'titulo' => 'AccesoLibre', 'enlace' => BASE_URL . 'acceso_libre'),
                array('id' => 'separador'),
                array('id' => 'estadisticas', 'titulo' => '::Estadísticas::', 'enlace' => BASE_URL . 'estadisticas'),
                array('id' => 'log', 'titulo' => '::Log::', 'enlace' => BASE_URL . 'log'),
            );

            $submenu['listados'] = array(
                array('id' => 'listados', 'titulo' => 'Centros', 'enlace' => BASE_URL . 'centro'),
                array('id' => 'listados', 'titulo' => 'Dinamizadores',
                    'enlace' => BASE_URL . 'dinamizador'),
            );
            $submenu['centros'] = array(
                array('id' => 'centro', 'titulo' => 'Lista de Centros', 'enlace' => BASE_URL . 'centro'),
                array('id' => 'centro', 'titulo' => 'Nuevo centro', 'enlace' => BASE_URL . 'centro/nuevo')
            );
            $submenu['dinamizadores'] = array(
                array('id' => 'dinamizador', 'titulo' => 'Lista de Dinamizadores',
                    'enlace' => BASE_URL . 'dinamizador'),
                array('id' => 'dinamizador', 'titulo' => 'Nuevo dinamizador', 'enlace' => BASE_URL . 'dinamizador/nuevo')
            );
            $submenu['innova'] = $this->getMenuInnova();
        }


        return $submenu;
    }

    public function getMenuRight()
    {
        $submenu = $this->getSubMenu();

        if (Session::getUserLevel() == Session::ROLE_USER) {
            $menu_right[] = array(
                'id' => array('dinamizador', 'centro'),
                'titulo' => 'Información',
                'enlace' => BASE_URL . 'dinamizador',
                'submenu' => $submenu['listados_usuarios']
            );
        }

        if (Session::get('autenticado')) {
            if (Session::esEspecial(Session::getId())) {
                $menu_right[] = array(
                    'id' => 'admin',
                    'titulo' => 'Administrador',
                    'enlace' => BASE_URL . 'alumno',
                    'submenu' => $submenu['admin']
                );
            }
            $menu_right[] = array(
                'id' => 'login',
                'titulo' => 'Usuario: <span class="label label-primary"><strong class="text-default">' . Session::get('nombre') . '</strong></span>',
                'enlace' => BASE_URL . 'dinamizador/editar/' . Session::get('id_usuario'),
                'submenu' => $submenu['login']
            );
        } else {
            $menu_right = array(
                array(
                    'id' => 'registro',
                    'titulo' => 'Registro',
                    'enlace' => BASE_URL . 'registro'
                ),
                array(
                    'id' => 'login1',
                    'titulo' => '<strong id="login" class="label ">Iniciar Sesión</strong>',
                    'enlace' => BASE_URL . 'login'
                )
            );
        }
        return $menu_right;
    }

    public function getMenuInnova()
    {
        $menu_innova = array();
        $menu_innova[] = array(
            'id' => 'aula',
            'titulo' => 'Usuarios',
            'enlace' => BASE_URL . 'aula_usuarios',
//          'submenu' => $submenu['curso']
        );
        
        $menu_innova[] = array(
            'id' => 'actividades',
            'titulo' => 'Actividades',
            'enlace' => BASE_URL . 'aula_actividades'
        );
        
        $menu_innova[] = array('id' => 'separador');
        
        $menu_innova[] = array(
            'id' => 'responsables',
            'titulo' => 'Responsables',
            'enlace' => BASE_URL . 'aula_responsables'
        );
        
        $menu_innova[] = array('id' => 'separador');
        
        $menu_innova[] = array(
            'id' => 'tipo_actividad',
            'titulo' => 'Tipos de Actividad',
            'enlace' => BASE_URL . 'aula_tipo_actividad'
        );
        

        return $menu_innova;
    }

}
