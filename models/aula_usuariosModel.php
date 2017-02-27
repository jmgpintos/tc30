<?php

class aula_usuariosModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuariosAula()
    {
        $table = $this->tbl_aula_usuarios;
        $sql = "SELECT * FROM {$table} ORDER BY apellidos, nombre";

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActividadesUsuario($idUsuario)
    {
        $table = $this->tbl_aula_usuarios_actividades;
        $sql = "SELECT id_actividad FROM {$table} "
                . " WHERE id_usuario = {$idUsuario} ";

        $row = $this->_db_->query($sql);

        $fila = $row->fetchAll(PDO::FETCH_ASSOC);

        if (count($fila) == 0) {
            return null;
        }

        $actividad = array();
        for ($i = 0; $i < count($fila); $i++) {
            $actividad[] = $fila[$i]['id_actividad'];
        }

        $table = $this->tbl_aula_actividades;
        $actividades = implode(',', $actividad);

        $t1 = $this->tbl_aula_tipo_actividad;

        $sql = "SELECT aa.id, aa.nombre nombre, ata.nombre tipo_actividad, "
                . "fecha_inicio, fecha_fin, hora_inicio, hora_fin, aa.descripcion"
                . " FROM {$table} aa"
                . " JOIN {$this->tbl_aula_tipo_actividad} ata ON aa.id_tipo=ata.id "
                . " WHERE aa.id IN ({$actividades})";

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function auto()
    {

        $nombres = array(
            'mujer' => array(
                'María', 'Laura', 'Cristina', 'Marta', 'Sara',
                'Andrea', 'Ana', 'Alba', 'Paula', 'Sandra'),
            'hombre' => array(
                'David', 'Alejandro', 'Daniel', 'Javier', 'Sergio',
                'Adrián', 'Carlos', 'Pablo', 'Álvaro')
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

        $num_nif = rand(13000000, 82000000);
        $nif = $num_nif . letra_nif($num_nif);

        $g = (rand(0, 99) % 2 == 1) ? 0 : 1;
        $sex = array('H', 'M');
        $sexo = $sex[$g];

        if ($sexo == 'M') {
            $nom = $nombres['mujer'];
        } else {
            $nom = $nombres['hombre'];
        }
        $nombre = $nom[rand(0, count($nom) - 1)];
        $apellido = $apellidos[rand(0, count($apellidos) - 1)];
        $rand = rand(0, 99999999);
        $mail = strtolower(Cadena::stripAccents($nombre)) . $rand . "@" . strtolower(Cadena::stripAccents($apellido)) . '.com';
        $apellido .= ' ' . $apellidos[rand(0, count($apellidos) - 1)];

        $tel = rand(600000000, 799999999);

        $int = rand(0, 820368000);
        $fecha_nac = date("Y-m-d H:i:s", $int);


        $table = $this->tbl_aula_usuarios;
        $SQL = "INSERT INTO {$table}(dni, nombre, apellidos, email, telefono, fecha_nacimiento, sexo)"
                . "VALUES('$nif', "
                . "'$nombre', "
                . "'$apellido', "
                . "'$mail', "
                . "'" . $tel . "', "
                . "'" . $fecha_nac . "', "
                . "'$sexo')";

//        puty($SQL);


        $this->_db_->query($SQL);
    }

}
