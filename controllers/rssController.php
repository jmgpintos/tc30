<?php

class rssController extends Controller {

    protected $_table = 'alumnos';
    protected $_modulo = 'rss';

    public function __construct()
    {
        parent::__construct();
        $this->_model = $this->loadModel('rss');
    }

    /**
     * Generar rss
     * 
     */
    public function index()
    {
        $linkCentro = "http://www.campussantanderemprende.com/redtelecentros/index.php?tc=";

        $this->getLibrary('rss_generator.inc');

        $rss_channel = new rssGenerator_channel();
        $rss_channel->atomLinkHref = '';
        $rss_channel->title = 'Cursos';
        $rss_channel->link = 'http://www.campussantanderemprende.com/redtelecentros/';
        $rss_channel->description = 'Los cursos de la red de telecentros del Ayuntamiento de Santander.';
        $rss_channel->language = 'es-ES';
        $rss_channel->generator = 'PHP RSS Feed Generator';
        $rss_channel->managingEditor = '';
        $rss_channel->webMaster = '';

        $link = 'http://www.campussantanderemprende.com/redtelecentros/index.php?cursos=1';

//llamar a la bd y recuperar registros para el feed
        $datos = $this->_model->getCursosRss();

//Crear un item para cada registro
        for ($i = 0; $i < count($datos); $i++) {

            $titulo = $datos[$i]['curso'] . ' -  ' . FechaHora::fechaATexto($datos[$i]['fecha_inicio']);
            $fechas = FechaHora::construirExprFecha(
                            $datos[$i]['fecha_inicio'], $datos[$i]['fecha_fin'], true);
            $horas = 'De ' . FechaHora::HoraCorta($datos[$i]['hora_inicio'])
                    . ' a ' . FechaHora::HoraCorta($datos[$i]['hora_fin']);
            $centro = "<a href={$linkCentro}{$datos[$i]['id_centro']}>" . $datos[$i]["centro"] . '</a>';
            $tfno = formato_telefono($datos[$i]['telefono']);
            $desc = <<<EOT
                    <![CDATA[
                    Curso de <strong>{$datos[$i]['curso']}</strong> en el centro {$centro}<p/>
                    Dirección: {$datos[$i]['direccion']}<br/>
                    Teléfono: {$tfno}<p/>
                    Horario: {$horas}<br/>
                    {$fechas}
                        ]]>
EOT;
                    
            //crear item
            $item = new rssGenerator_item();
            $item->title = $titulo;
            $item->description = $desc;
            $item->link = $link;
            $item->pubDate = date('r'); //Fecha actual RFC822
            //
            //añadir item al feed
            $rss_channel->items[] = $item;
        }

        $rss_feed = new rssGenerator_rss();

        $this->_view->assign('encoding', "UTF-8");
        $this->_view->assign('version', "2.0");
        $this->_view->assign('header', "header('Content-Type: text/xml')");
        $this->_view->assign('contenido', $rss_feed->createFeed($rss_channel));

        $feed = $rss_feed->createFeed($rss_channel);

        // enviar feed al navegador
        header('Content-Type: text/xml');
        header('Content-Length: ' . strlen($feed));
        echo $feed;
    }

}
