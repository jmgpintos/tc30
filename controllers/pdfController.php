<?php

class pdfController extends Controller {

    private $pdf;
    private $orientacion; // P|L
    private $unidades = 'mm'; //mm|pt|cm|in
    private $formato = 'A4'; //A4|Carta|Legal
    private $_author = "Red de Telecentros del Ayuntamiento de Santander";
    private $font_calibri;

//    protected $_modulo='pdf';


    function __construct($orientacion = 'P')
    {
        parent::__construct();

        $this->getLibrary('tcpdf/tcpdf_import');
        $this->pdf = new TCPDF($orientacion, $this->unidades, $this->formato, true, 'UTF-8', false);

        $this->_model = $this->loadModel('pdf');

//        $pdf->addTTFfont(ROOT.'public'.DS.ttf.DS.'calibri.ttf', '', '', 32);
    }

    function index()
    {
        
    }

    public function certificado($pdfFile, $filename, $subject, $margen)
    {

        ob_get_clean(); //limpiar cache
// set document information
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor($this->_author);
        $this->pdf->SetTitle('Certificado');
        $this->pdf->SetSubject($subject);
        $this->pdf->SetKeywords('certificado, telecentros, Santander');

// set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        define('PDF_MARGIN_FACTOR', $margen / 10);
        $this->pdf->SetMargins(PDF_MARGIN_LEFT * PDF_MARGIN_FACTOR, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT * PDF_MARGIN_FACTOR);

// set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $this->pdf->SetFont('dejavusans', '', 12, '', true);

//Crear página
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);
        $this->pdf->AddPage();


//LOGO-AYTO
        $margins = $this->pdf->getMargins();
        $leftMargin = $margins['left'];
        $this->pdf->SetX($leftMargin, 0);
        $logo = LIB_PATH . "tcpdf/images/logo-ayto.jpg";
        $this->pdf->Image($logo, '', '', 80);
        $this->pdf->Ln(20);

//Linea horizontal
        $pageWidth = $this->pdf->getPageWidth();

        $y1 = $y2 = $this->pdf->GetY() * 1.2;
        $this->pdf->Line($leftMargin, $y1, $pageWidth - $leftMargin, $y2);

//texto
        $this->pdf->writeHTML($pdfFile, true);

        $this->pdf->Output($filename, 'I');
        
        Log::info('Certificado', array($filename));
    }

    public function hojaCursos($html)
    {
        ob_get_clean(); //limpiar cache
//Crear página
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);

        $this->pdf->AddPage();


//texto
//        echo $html;exit;
        $this->pdf->writeHTML($html, true);

        $this->pdf->Output('$filename', 'I');
        
    }

    public function imprimirHojaCurso($cursos, $conAlumnos)
    {
        ob_get_clean(); //limpiar cache
//Crear página
        $this->pdf->setPrintFooter(false);
        $this->pdf->setPrintHeader(false);



//        vardumpy($cursos);
        $c = new ficha_cursosController();
        foreach ($cursos as $curso) {
            $this->pdf->AddPage();
            $datosHoja = array();
            $datosHoja['nombre_curso'] = $curso['curso'];
            $datosHoja['centro'] = $curso['centro'];
            $datosHoja['profesor'] = $this->getNombreApellido($curso['nom_pro'], $curso['ape_pro']);
            $datosHoja['fecha'] = FechaHora::construirExprFecha(
                            $curso['fecha_inicio'], $curso['fecha_fin']);
            $datosHoja['hora'] = 'De ' . substr($curso['hora_inicio'], 0, 5)
                    . ' a ' . substr($curso['hora_fin'], 0, 5);

            $aforo = $c->_model->getAforoCentro($curso['id_centro']);
            $alumnos = $c->_model->getAlumnosCurso($curso['id']);
//        vardumpy($alumnos);

            $totalAlumnos = count($alumnos);

            $listado = array();
            for ($index = 0; $index < $aforo + 5; $index++) {
                $row = $index + 1;
                if ($index < $aforo) {
                    $listado[$index]['row'] = $row;
                } else {
                    $listado[$index]['row'] = 'R' . ($row - $aforo);
                }
                if ($index < $totalAlumnos && $conAlumnos) {
                    $listado[$index]['dni'] = $alumnos[$index]['dni'];
                    $listado[$index]['nombre'] = $this->getNombreApellido($alumnos[$index]);
                    $listado[$index]['telefono'] = formato_telefono($alumnos[$index]['telefono']);
                    $listado[$index]['ocupacion'] = $this->_model->getNameById('ocupacion', $alumnos[$index]['id_ocupacion']);
                } else {
                    $listado[$index]['dni'] = '';
                    $listado[$index]['nombre'] = '';
                    $listado[$index]['telefono'] = '';
                    $listado[$index]['ocupacion'] = '';
                }
            }
            for ($index = 0; $index < $totalAlumnos; $index++) {
                
            }

            $html = $this->_tablaCurso($listado, $datosHoja);

            $this->pdf->writeHTML($html, true);
        }

        $this->pdf->Output('fichasCursos.pdf', 'I');
    }

    private function _tablaCurso($listado, $datosHoja)
    {
        $estilo = $this->_estilo_tablaCurso();
        $tbl_tc = $this->_tbl_tc_tablaCurso($datosHoja);
        $tabla_html = $this->_tabla_html_tablaCurso($listado);

        $p = <<<EOT
                <span align="right" style= "font-size:75%;">Profesor: {$datosHoja['profesor']}</span>
EOT;

        $header = <<<EOT
                <h2>Alfabetizaci&oacute;n Digital Telecentros</h2>
                <h3>Ayuntamiento de Santander</h3>
EOT;


        $espacio = "<br/><br/>";



        $html = null;
        $html .= $estilo . PHP_EOL;
        $html .= $header . PHP_EOL;
        $html.= $tbl_tc . PHP_EOL;
        $html.= $espacio . PHP_EOL;
        $html.= $tabla_html . PHP_EOL;
        $html.= $p;

        return $html;
    }

    private function _estilo_tablaCurso()
    {
        $estilo = <<<EOT
                <style>
                    body{
                        font-family: sans-serif;
                        }
                    h2{
                        font-weight: bold;
                        text-align:center;
                        margin: 5px;
                        border-bottom: 1px solid black;
                    }
                    h3{
                        text-align: center;
                        font-weight: 300;
                    }
                    table{
                        border-collapse:collapse;
                        border: 2px solid black;
                        margin:auto;
                        margin-bottom:5px;
                        width: 100%;
                    }
                    tr{
                    }
                    td{
                        padding:15px;
                        border: 1px solid black;
                    }
                    td:first-child{
                        text-align:left;
                        padding-left:15px;
                    }
                    th{
                        background-color:lightgray;
                        color:white;
                        padding:5px;
                    }
                    tr:nth-child(odd){
                        background-color:#efefef;
                    }
                    .ultimas5{
                        background-color:lightgray;
                    }
                    .tabla-enc{
                        line-heigth: 150%;
                    }
                </style>
EOT;

        return $estilo;
    }

    private function _tbl_tc_tablaCurso($datosHoja)
    {
        $tbl_tc = <<<EOT
                <table cellpadding="4" border="0">
                    <thead >
                        <tr>
                            <th> Telecentro </th>
                            <th> Curso </th>
                            <th> Fecha </th>
                            <th> Horario </th>
                        </tr>
                    </thead>
                    <tr>
                        <td align="center">{$datosHoja['centro']}</td>
                        <td align="center"> {$datosHoja['nombre_curso']}</td>
                        <td align="center">{$datosHoja['fecha']}</td>
                        <td align="center">{$datosHoja['hora']}</td>
                    </tr>
                </table>
EOT;

        return $tbl_tc;
    }

    public function _tabla_html_tablaCurso($listado)
    {

        $tabla_html = <<<EOT
            <table cellpadding="4" width="100%" >
                <tr>
                    <th width = "5%"></th>
                    <th width = "45%">Nombre y apellidos</th>
                    <th width = "15%">D.N.I.</th>
                    <th width = "15%">Situaci&oacute;n Laboral</th>
                    <th width = "20%">Tel&eacute;fono</th>
                </tr>
EOT;

        for ($index = 0; $index < count($listado); $index++) {
            if ($index > count($listado) - 6) {
                $tabla_html .='<tr style="background-color:#e7e7e7">' . PHP_EOL;
            } else {
                $tabla_html .='<tr>' . PHP_EOL;
            }
            $tabla_html .='<td width = "5%" style="background-color:#e7e7e7" align="center">' . $listado[$index]['row'] . '</td>' . PHP_EOL;
            $tabla_html .='<td width = "45%">' . $listado[$index]['nombre'] . '</td>' . PHP_EOL;
            $tabla_html .='<td width = "15%">' . $listado[$index]['dni'] . '</td>' . PHP_EOL;
            $tabla_html .='<td width = "15%">' . $listado[$index]['ocupacion'] . '</td>' . PHP_EOL;
            $tabla_html .='<td width = "20%">' . $listado[$index]['telefono'] . '</td>' . PHP_EOL;
            $tabla_html .='</tr>' . PHP_EOL;
        }

        $tabla_html .= '</table>' . PHP_EOL;

        return $tabla_html;
    }

}
