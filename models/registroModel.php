<?php

class registroModel extends Model {

    private $_table;

    public function __construct()
    {
        parent::__construct();
        $this->_table = $this->tbl_usuarios;
        ;
    }

    public function verificarUsuario($usuario)
    {
        $id = $this->_db_->query(
                "SELECT id FROM {$this->_table} WHERE usuario= '$usuario'"
        );
        if ($id->fetch()) {
            return true;
        }

        return false;
    }

    public function verificarEmail($email)
    {
        $id = $this->_db_->query(
                "SELECT id FROM {$this->_table} WHERE email= '$email'"
        );

        if ($id->fetch()) {
            return true;
        }

        return false;
    }

    public function registrarUsuario($nombre, $apellidos, $usuario, $password, $email, $telefono)
    {
//        put('DEFAULT_ROLE: ', DEFAULT_ROLE);
//        $SQL = "INSERT INTO usuarios " .
//                        "VALUES( null, '$nombre', '$usuario', '$password', '$email', '$telefono' ,".DEFAULT_ROLE.", 1, now(),null,null, null)";
//        put ($SQL);
//        exit;
        $sql = "INSERT INTO {$this->_table} " .
                "VALUES( null, :nombre, :apellidos, :usuario, :password, :email, :telefono, '" . DEFAULT_ROLE . "', 0, now(),null,null, null)";
        $campos = array(
            ':nombre' => $nombre,
            ':apellidos' => $apellidos,
            ':usuario' => $usuario,
            ':password' => Hash::getHash('sha1', $password, HASH_KEY),
            ':email' => $email,
            ':telefono' => $telefono
        );
        
//put($sql);
//vardumpy($campos);
        $this->_db_->prepare($sql)
                ->execute($campos);
//
//        put($sql);
//        vardumpy($campos);
//        puty($this->_db_->lastInsertId());
        return $this->_db_->lastInsertId(); //devolver ID del registro insertado
    }

}
