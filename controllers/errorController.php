<?php

class errorController extends Controller {
    
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->_view->assign('titulo', 'Error');
        $e = $this->_getError();
        $this->_view->assign('_mensajeerror', $e['h2']);
        $this->_view->assign('_texto', $e['p']);
        $this->_view->renderizar_template('index');
    }

    public function access($codigo = false, $item1 = false, $item2 = false)
    {
        
        
        $this->_view->assign('titulo', 'Error');
        $e = $this->_getError($codigo, $item1, $item2);
        $this->_view->assign('_mensajeerror', $e['h2']);
        $this->_view->assign('_texto', $e['p']);

        $this->_view->assign('destino', Session::get('destino'));

        $this->_view->renderizar_template('access');
    }

    private function _getError($codigo = false, $item1 = false, $item2 = false)
    {
        if ($codigo) {
            $codigo = $this->filtrarInt($codigo);
            if (is_int($codigo)) {
                $codigo = $codigo;
            }
        } else {
            $codigo = 'default';
        }

        //Cambiar flechas por slash (se mandan flechas para que no lo coja como varios argumentos)
        if ($item1) {
            $item1 = str_replace('->', '/', $item1);
        }
        if ($item2) {
            $item2 = str_replace('->', '/', $item2);
        }


        $gracia = "<hr><h3 class='text-danger'>Gracias por venir a jugar</h3>";
        $error['default']['h2'] = 'Error no definido';
        $error['default']['p'] = 'Ha ocurrido un error y la p&aacute;gina no puede mostrarse';
        $error['5050']['h2'] = 'Acceso restringido';
        $error['5050']['p'] = 'No tiene permisos suficientes para realizar esta acci&oacute;n';
        $error['8080']['h2'] = 'Tiempo de la sesi&oacuten agotado';
        $error['8080']['p'] = 'Se ha excedido el tiempo de la sesi&oacuten';
        $error['404']['h2'] = 'P&aacute;gina no encontrada';
        $error['404']['p'] = 'La p&aacutegina solicitada <em>' . $item1 . '</em> no existe en este servidor.' . $gracia;
        $error['804']['h2'] = 'Par&aacutemetro incorrecto';
        $error['804']['p'] = 'El par&aacutemetro <em><strong>(' . $item2 . ')</strong></em> entregado al m&eacutetodo <em>' . $item1 . '</em> es incorrecto' . $gracia;
        $error['805']['h2'] = 'Error de paginación';
        $error['805']['p'] = 'El par&aacutemetro entregado al m&eacutetodo <em>' . $item1 . '</em> es incorrecto.' . $gracia;
        $error['900']['h2'] = 'Error de conexión';
        $error['900']['p'] = Session::get('DBerror');

        if (array_key_exists($codigo, $error)) {
            return $error[$codigo];
        } else {
            return $error['default'];
        }
    }

}
