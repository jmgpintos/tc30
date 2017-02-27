<?php

class dinamizadorModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function nuevo_dinamizador_auto()
    {
        $nombres = array(
            'María',
            'Laura',
            'Cristina',
            'Marta',
            'Sara',
            'Andrea',
            'Ana',
            'Alba',
            'Paula',
            'Sandra',
            'David',
            'Alejandro',
            'Daniel',
            'Javier',
            'Sergio',
            'Adrián',
            'Carlos',
            'Pablo',
            'Álvaro',
        );
        $apellidos = array(
            'Alonso', 'Álvarez', 'Blanco', 'Calvo', 'Cano',
            'Castillo', 'Castro', 'Delgado', 'Díaz', 'Díez',
            'Domínguez', 'Fernández', 'García', 'Garrido', 'Gil',
            'Gómez', 'González', 'Gutiérrez', 'Hernández', 'Iglesias',
            'Jiménez', 'López', 'Lozano', 'Marín', 'Martín',
            'Martínez', 'Medina', 'Molina', 'Morales', 'Moreno',
            'Muñoz', 'Navarro', 'Núñez', 'Ortega', 'Ortiz',
            'Pérez', 'Prieto', 'Ramírez', 'Ramos', 'Rodríguez',
            'Romero', 'Rubio', 'Ruiz', 'Sánchez', 'Santos',
            'Sanz', 'Serrano', 'Suárez', 'Torres', 'Vázquez'
        );
        $nombre = $nombres[rand(0, count($nombres))];
        $apellido = $apellidos[rand(0, count($apellidos))];

        $rand = rand(0, 99999999);
        $mail = limpiar(strtolower($nombre)) . $rand . "@" . limpiar(strtolower($apellido)) . '.com';
        $tel = rand(600000000, 799999999);
        $SQL = "INSERT INTO usuarios(nombre, usuario, password, email, telefono, estado, fecha)"
                . "VALUES('$nombre $apellido','user" . $rand . "','" . Hash::getHash('sha1', '1324', HASH_KEY) . "',' $mail ','" . $tel . "',1,now())";
        $this->_db_->query($SQL);
    }

    public function getAll($table = 'usuarios')
    {
        $table = $this->getTableName($table);
        $tbl_centros = $this->getTableName('centros');

        $sql = "SELECT us.*, ce.nombre centro "
                . "FROM {$table} us "
                . "LEFT JOIN {$tbl_centros} ce ON us.id_centro = ce.id "
                . "ORDER BY us.estado DESC, us.apellidos, us.nombre, fecha DESC";

        $row = $this->_db_->query($sql);
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivos()
    {
        $table = 'usuarios';
        $table = $this->getTableName('usuarios');

        $tbl_centros = $this->getTableName('centros');

        $sql = "SELECT us.*, ce.nombre centro "
                . "FROM {$table} us "
                . "LEFT JOIN {$tbl_centros} ce ON us.id_centro = ce.id "
                . "WHERE us.estado "
                . "ORDER BY us.apellidos, us.nombre, fecha DESC";

        $row = $this->_db_->query($sql);
//        vardump($sql);
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCentros()
    {
        $sql = "SELECT id, nombre from centros";


        $row = $this->_db_->query($sql);
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function emailRepetido($id, $email)
    {
        $table = 'usuarios';
        $table = $this->getTableName($table);

        $sql = "SELECT * FROM {$table} WHERE id!={$id} AND email='{$email}'";
//        puty($sql);
        $row = $this->_db_->query($sql);

        if ($row->fetch()) {
            return true;
        }

        return false;
    }

    public function usuarioRepetido($id, $usuario)
    {
        $table = 'usuarios';
        $table = $this->getTableName($table);

        $sql = "SELECT * FROM {$table} WHERE id!={$id} AND usuario='{$usuario}'";
//        puty($sql);
        $row = $this->_db_->query($sql);

        if ($row->fetch()) {
            return true;
        }

        return false;
    }

    public function getPassword($idUsuario)
    {

        $sql = "SELECT password from {$this->tbl_usuarios} WHERE id = {$idUsuario}";


        $row = $this->_db_->query($sql);
        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['password'];
    }

    public function setDefaultPassword($idUsuario)
    {

        $table = $this->getTableName('usuarios');
        $sql = "SELECT password FROM {$table} WHERE id = $idUsuario";
        $row = $this->_db_->query($sql);
        $fila = $row->fetch(PDO::FETCH_ASSOC);
        $pw_anterior = $fila['password'];

        Log::info('password cambiado', array(
            'tabla' => $table,
            'id_usuario' => $idUsuario,
            'pw_anterior' => $pw_anterior)
        );

        $campos = array(
            ':password' => Hash::getHash('sha1', DEFAULT_PASSWORD, HASH_KEY),
            ':id' => $idUsuario
        );

        $sql = "UPDATE $table SET password=:password WHERE id = :id";

        $stmt = $this->_db_->prepare($sql);
        return $stmt->execute($campos);
    }

    /**
     * Devuelve el número de dinamizadores asignados a un centro
     * si id_centro = 0; devuelve 0
     * 
     * @param int $id_centro
     * @return int
     */
    public function dinamizadoresEnCentro($id_centro)
    {
        if ($id_centro) {
            $sql = "SELECT count(*) cuenta from {$this->tbl_usuarios} WHERE id_centro = {$id_centro} AND estado";

            $row = $this->_db_->query($sql);
            $fila = $row->fetch(PDO::FETCH_ASSOC);

            return $fila['cuenta'];
        }
        return $id_centro;
    }

}
