<?php

class indexController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $post = $this->loadModel('post');

//        $this->_view->posts = $post->getPosts();
//        $this->_view->titulo = APP_NAME;
        
        $this->_view->assign('posts', $post->getPosts());
        $this->_view->assign('titulo',  '');
        
        
        $this->_view->renderizar_template('index', 'inicio');
    }

    public function verTablas()
    {

        $database = 'mvc';
        $this->_model = $this->loadModel('alumno');
        $dbs = $this->_model->getAllTablesName($database);

        for ($i = 0; $i < count($dbs); $i++) {
            $db[] = $dbs[$i][0];
        }

        for ($i = 0; $i < count($db); $i++) {
            $tablas[] = $this->_model->getTableInfo($db[$i], $database);
        }

        $estilo = <<<EOT
                <style>
                    body{
                        font-family: sans-serif;
                        }
                    h1{
                        margin: auto 20% 20px;
                        }
                    h2{
                        margin: auto 20% 10px;
                        }
                    h1{
                        border-bottom:3px solid black;
                        }
                    table{
                        border-collapse:collapse;
                        border: 3px solid black;
                        width:50%;
                        margin:auto;
                        margin-bottom:15px;
                        font-size:75%;
                    }
                    td{
                        padding:5px;
                        text-align:center;
                    }
                td:first-child{
                        text-align:left;
                        padding-left:15px;
                    }
                    th{
                        background-color:black;
                        color:white;
                        padding:5px;
                    }
                    tr:nth-child(odd){
                        background-color:lightgray;
                        }
                    pre{
                        width: 50%;
                        margin:auto;
                        margin-bottom: 15px;
                        padding-bottom: 3px;
                        border-bottom: 1px solid black;
                        font-size: 75%;
                    }
                </style>
EOT;

        echo $estilo;
        echo "<h1>database: " . $database . "</h1>";

        for ($i = 0; $i < count($tablas); $i++) {
            echo "<h2>table: " . $db[$i] . "</h2>";
            echo $this->array2table($tablas[$i]);
//            echo "<pre>".$this->_model->getCreateTable($db[$i], $database)[1]."</pre>";
        }
    }

    function array2table($array, $recursive = false, $null = '&nbsp;')
    {
        // Sanity check
        if (empty($array) || !is_array($array)) {
            return false;
        }

        if (!isset($array[0]) || !is_array($array[0])) {
            $array = array($array);
        }

        // Start the table
        $table = "<table>\n";

        // The header
        $table .= "\t<tr>";
        // Take the keys from the first row as the headings
        foreach (array_keys($array[0]) as $heading) {
            $table .= '<th>' . $heading . '</th>';
        }
        $table .= "</tr>\n";

        // The body
        foreach ($array as $row) {
            $table .= "\t<tr>";
            foreach ($row as $cell) {
                $table .= '<td>';

                // Cast objects
                if (is_object($cell)) {
                    $cell = (array) $cell;
                }

                if ($recursive === true && is_array($cell) && !empty($cell)) {
                    // Recursive mode
                    $table .= "\n" . array2table($cell, true, true) . "\n";
                } else {
                    $table .= (strlen($cell) > 0) ?
                            htmlspecialchars((string) $cell) :
                            $null;
                }

                $table .= '</td>';
            }

            $table .= "</tr>\n";
        }

        $table .= '</table>';
        return $table;
    }
    
public function p()
    {

        $this->_model = $this->loadModel('alumno');
        $table = 'alumnos';
        $nenes = $this->_model->p();
        put(count($nenes));
        for ($i = 0; $i < count($nenes); $i++) {
            $n = 'N' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            $campos = array(':p' => $n);
            $this->_model->editarRegistro($table, $nenes[$i]['id'],$campos);
//            put($nenes[$i]['id'] . ': ' . $nenes[$i]['dni'] . ' - ' .$nenes[$i]['p'] . ' - ' . $n. '-----'.$nenes[$i]['fechaNac']);
        }
    }
    }