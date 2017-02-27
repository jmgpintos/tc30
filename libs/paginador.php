<?php

define('GLYPH_PAG_PRIMERA', '<span class="glyphicon glyphicon-triangle-left"></span>');
define('GLYPH_PAG_ANTERIOR', '<span class="glyphicon glyphicon-menu-left"></span>');
define('GLYPH_PAG_SIGUIENTE', '<span class="glyphicon glyphicon-menu-right"></span>');
define('GLYPH_PAG_ULTIMA', '<span class="glyphicon glyphicon-triangle-right"></span>');

class Paginador {

    private $_datos;
    private $_paginacion;

    public function __construct()
    {
        $this->_datos = array();
        $this->_paginacion = array();
    }
    
    function get_paginacion()
    {
        return $this->_paginacion;
    }

        public function paginar($query, $pagina = false, $limite = false, $paginas = false)
    {

        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = 5;
        }

        if ($pagina && is_numeric($pagina)) {
            $pagina = $pagina;
            $inicio = ($pagina - 1) * $limite;
        } else {
            $pagina = 1;
            $inicio = 0;
        }

        //Para que cuando se borre el último registro de la página actual vaya a la página anterior
        if ($pagina > ceil(count($query) / $limite)) {
            if ($inicio - $limite > 0) {
                $inicio = $inicio - $limite;
                if($pagina>0) $pagina--;
            }
        }
        

        $total = ceil(count($query) / $limite);
        $this->_datos = array_slice($query, $inicio, $limite);

        $paginacion = array();
        $paginacion['actual'] = $pagina;
        $paginacion['total'] = $total;

        if ($pagina > 1) {
            $paginacion['primero'] = 1;
            $paginacion['anterior'] = $pagina - 1;
        } else {
            $paginacion['primero'] = '';
            $paginacion['anterior'] = '';
        }

        if ($pagina < $total) {
            $paginacion['ultimo'] = $total;
            $paginacion['siguiente'] = $pagina + 1;
        } else {
            $paginacion['ultimo'] = '';
            $paginacion['siguiente'] = '';
        }

        $this->_paginacion = $paginacion;
        $this->_rangoPaginacion($paginas);

               
        return $this->_datos;
    }

    private function _rangoPaginacion($limite = false)
    {
        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = 10;
        }

        $total_paginas = $this->_paginacion['total'];
        $pagina_seleccionada = $this->_paginacion['actual'];
        $rango = ceil($limite / 2);
        $paginas = array();

        $rango_derecho = $total_paginas - $pagina_seleccionada;

        if ($rango_derecho < $rango) {
            $resto = $rango - $rango_derecho;
        } else {
            $resto = 0;
        }

        $rango_izquierdo = $pagina_seleccionada - ($rango + $resto);

        for ($i = $pagina_seleccionada; $i > $rango_izquierdo; $i--) {
            if ($i == 0) {
                break;
            }

            $paginas[] = $i;
        }

        sort($paginas);

        if ($pagina_seleccionada < $rango) {
            $rango_derecho = $limite;
        } else {
            $rango_derecho = $pagina_seleccionada + $rango;
        }

        for ($i = $pagina_seleccionada + 1; $i <= $rango_derecho; $i++) {
            if ($i > $total_paginas) {
                break;
            }

            $paginas[] = $i;
        }

        $this->_paginacion['rango'] = $paginas;

        return $this->_paginacion;
    }

    public function getView($vista, $link = false)
    {
        $rutaView = ROOT . 'views' . DS . '_paginador' . DS . $vista . '.php';

        if ($link) {
            $link = BASE_URL . $link . '/';
        }

        if (is_readable($rutaView)) {
            ob_start();

            include $rutaView;

            $contenido = ob_get_contents();

            ob_end_clean();

            return $contenido;
        }

        throw new Exception('Error de paginaci&oacute;n');
    }
}
?>
