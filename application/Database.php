<?php

class Database extends PDO {

    public function __construct()
    {
        include_once(ROOT . DS . 'controllers' . DS . 'errorController.php');
        try {
            parent::__construct(
                    'mysql:host=' . DB_HOST .
                    ';dbname=' . DB_NAME, DB_USER, DB_PASS, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . DB_CHAR));
        } catch (PDOException $e) {
            $err = new errorController();

            Session::set('DBerror', 'Se ha producido un error al conectar con la base de datos. C&oacute;digo de error: ' .
                    $e->getCode() . '<hr>' . mb_convert_encoding($e->getMessage(), 'utf-8', 'iso-8859-1') . '<br>');

            $err->saltar_error(900);
        }
        
//        $sql = "SHOW DATABASES LIKE '" . DB_NAME . "'";
//        $row = $this->query($sql);
//
//        $rs = $row->fetchAll(PDO::FETCH_ASSOC);
//        if (count($rs) != 1) {
//            $err = new errorController();
//            $err->saltar_error(900);
//        }
    }

}
