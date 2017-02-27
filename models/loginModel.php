<?php

class loginModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario($usuario, $password)
    {
        $table = 'usuarios';
        $table = $this->getTableName($table);
        
        $sql = "SELECT * FROM {$table} " .
                "WHERE usuario = '$usuario' " .
                "AND password = '" . Hash::getHash('sha1', $password, HASH_KEY) . "'";
//        put($sql);
//        put($usuario);
//        put($password);
//        vardump($this->_db_);
        $datos = $this->_db_->query($sql);
//vardumpy($datos);
        return $datos->fetch();
    }
}