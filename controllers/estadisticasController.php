<?php

class estadisticasController extends Controller {

//     protected $_table = 'alumnos';
  protected $_modulo = 'estadisticas';
  private $_titulo;

  function __construct()
  {
    parent::__construct();
    $this->_model = $this->loadModel('estadisticas');

    $this->_titulo = "Estad&iacute;sticas | ";
  }

  public function index()
  {
    Session::acceso(Session::ROLE_ADMIN);
    $this->_titulo .= 'Seleccionar';

    $this->_view->setJs(array('seleccionarChkBoxes'));
    /* Mostrar array $metodos en pantalla (varias columnas) con checkbox para seleccionar cuál/cuales se quieren ver) */
    $metodos = $this->_metodosSQL();
    $totalMetodos = count($metodos);

    $metodos1 = array_slice($metodos, 0, $totalMetodos / 2);
    $metodos2 = array_slice($metodos, $totalMetodos / 2, $totalMetodos);

    $this->_view->assign('metodos_sql', $metodos);
    $this->_view->assign('metodos_sql1', $metodos1);
    $this->_view->assign('metodos_sql2', $metodos2);
    $this->_view->assign('titulo', $this->_titulo);

    if (array_key_exists('checkbox', $_POST)) {
      $seleccionados = $_POST['checkbox'];
      $this->_view->assign('seleccionados', $seleccionados);
    }


    if ($this->getPostParam('guardar') == 1) {
      $this->_view->assign('datos', $_POST);

      if (!$this->_comprobarDatosFormulario()) {
        $this->_view->renderizar_template('index', $this->_modulo);
        exit;
      }

      $desde = $this->getPostParam('desde');
      $hasta = $this->getPostParam('hasta');
      $this->_model->setFechas($desde, $hasta);



      $metodos = $this->_metodosSQL();

      $datos = array();
      for ($i = 0; $i < count($metodos); $i++)
      {
        $consulta = $metodos[$i]['metodo'];
        $result = call_user_func(array($this->_model, $consulta));

        $sql = $result[0];
        $datos = $result[1];
        $nombre = explode('::sql', $result[2]);
        $nombre = ($this->_separar($nombre[1]));
        vardump($datos);

        $xxx[] = array(
            'sql' => $sql,
            'datos' => $datos,
            'nombre' => $nombre
        );
      }

//      for ($i = 0; $i < count($xxx); $i++)
//      {
//        vardump($xxx[$i]['sql']);
//      }
//      $rs = $this->_model->sqlAlumnosXProcedencia();
//      vardumpy($rs);
    }



    $this->_view->renderizar_template('index', $this->_modulo);
    vardump($_POST);
  }

  public function index1($pagina = 1)
  {
    Session::acceso(Session::ROLE_ADMIN);

    $metodos = $this->_metodosSQL();
//    vardumpy($metodos);

    $post = $this->getInt('sql');

    if ($post == 0) {
      $sqlID = Session::get('sqlID');
    } else {
      $sqlID = $this->getInt('sql');
    }

    Session::set('sqlID', $sqlID);

    $consulta = $metodos[$sqlID-1]['metodo'];
//    put($consulta);
    //Llamar al método según el valor del select
    $result = call_user_func(array($this->_model, $consulta));


    $sql = $result[0];
    $datos = $result[1];
//        vardump($datos);
    $nombre = explode('::sql', $result[2]);
    $nombre = ($this->_separar($nombre[1]));


    $this->_titulo .= '<small>' . $nombre . '</small>';

    //Encabezados de columna
    $titulos = $this->_encabezadosColumna($datos[0]);
    $formato = $this->_formatoColumna($datos);
    $this->_formatoTotales(); //FALTA


    $this->getLibrary('paginador');
    $paginador = new Paginador();
    $this->_view->assign('pagina', $pagina);
    Session::set('pagina', $pagina);

    $this->_view->assign('datos', $paginador->paginar($datos, $pagina, LINES_PER_PAGE));
    $this->_view->assign('paginacion', $paginador->getView('paginas', $this->_modulo . '/index1'));


    $this->_view->assign('titulo', $this->_titulo);
    $this->_view->assign('cols', $titulos);
    $this->_view->assign('formato', $formato);

//        $sql = $this->getInt('sql');
//        put($sql);
    $this->_view->assign('sql', $sqlID);
    $this->_view->assign('codigo_sql', $sql);
    $this->_view->assign('metodos_sql', $metodos);

    $this->_view->renderizar_template('index1', $this->_modulo);
  }

  public function _encabezadosColumna($datos)
  {
    $titulos[] = array_keys($datos);
    $titulos = $titulos[0];
    for ($i = 0; $i < count($titulos); $i++)
    {
      $titulos[$i] = ucfirst($titulos[$i]);
    }
    return $titulos;
  }

  public function _formatoColumna($datos)
  {
    $cols = $datos[0];
//        put($cols['centro']);

    $formato = array();

    foreach ($cols as $k => $v)
    {
//            put($k . '=>'.$v);
      if ($k == '%') {
        $formato[$k]['simbolo'] = '%';
        $formato[$k]['accion'] = 'round';
      }


      if (is_numeric($v)) {
        $formato[$k]['estilo'] = 'text-right';
      } else {
        $formato[$k]['estilo'] = 'text-left';
      }
    }

//        vardump($cols);
//        vardumpy($formato);
    return $formato;
  }

  public function _separar($nombre)
  {
    $exp = str_split($nombre);

    for ($i = 0; $i < count($exp); $i++)
    {
      if (ctype_upper($exp[$i])) {
        $exp[$i] = ' ' . strtolower($exp[$i]);
      }
    }
    $nombre = Cadena::capitalizar(trim(implode('', $exp), 'sql '));
//
//        return Cadena::capitalizar(trim(implode('', $exp)));
    return str_replace('X', ' | ', $nombre);
  }

  public function _metodosSQL()
  {
    $metodos = get_class_methods($this->_model);

    $metodosSQL = array();
    $j=1;
    for ($i = 0; $i < count($metodos); $i++)
    {
      if (Cadena::startsWith($metodos[$i], 'sql')) {
        $metodosSQL[] = array(
            'id' => $j,
            'metodo' => $metodos[$i],
            'nombre' => $j++ . '.- ' . $this->_separar($metodos[$i])
        );
      }
    }

//        vardumpy($metodosSQL);
    return $metodosSQL;
  }

  private function _formatoTotales()
  {


    /*     * ************FALTA ***************** */
//SUBTOTAL
//        foreach ($datos as $dato) {
//            foreach ($dato as $k => $v) {
//                if (is_null($v)) {
//                    $dato[$k] = 'Subtotal';
//                }
//            }
//        }
//TOTAL GENERAL
//        foreach ($datos[count($datos) - 1] as $k => $v) {
//            if (is_null($v)) {
//                $datos[count($datos) - 1][$k] = "TOTAL";
//            }
//        }
    /*     * ********************************* */
  }

  private function _comprobarDatosFormulario()
  {
    $err = null;

    if (!datecheck($this->getPostParam('desde'))) {
      $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fecha_inicio');
    } elseif (!datecheck($this->getPostParam('hasta'))) {
      $err = 'Debe introducir una fecha correcta' . $this->getPostParam('fecha_fin');
    } elseif ($this->getPostParam('hasta') < $this->getPostParam('desde')) {
      $err = 'La fecha de fin debe ser posterior a la fecha de inicio';
    } elseif (count($_POST['checkbox']) < 1) {
      $err = 'Debe seleccionar al menos una consulta';
    }

    if ($err) {
      $this->_view->assign('error', $err);
      return false;
    } else {
      return true;
    }
  }

}