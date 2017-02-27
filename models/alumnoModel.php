<?php

class alumnoModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Devuelve los cursos del alumno con id = $id
     * 
     * @param int $id
     * 
     * return array Recordset con los resultados de la consulta
     */
    public function get_cursos_alumno($id)
    {
        $id = (int) $id;
        
        $tbl_ficha_alumnos = $this->getTableName('ficha_alumnos');
        $tbl_ficha_cursos = $this->getTableName('ficha_cursos');
        $tbl_centros = $this->getTableName('centros');
        $tbl_cursos = $this->getTableName('cursos');
        
        $SQL = "SELECT `fa`.`id_alumno` AS `id_alumno`,
                  `fa`.`id_ficha_curso` AS `id_ficha_curso`,
                  `fc`.`fecha_inicio` AS `fecha_inicio`,
                  `fc`.`hora_inicio` AS `hora_inicio`,
                  `cu`.`id` as `id_curso`,
                  `cu`.`nombre` AS `nombre_curso`,
                  `ce`.`nombre` AS `nombre_centro`,
                  `fa`.`certificado` AS `certificado` 
              from (((`{$tbl_ficha_alumnos}` `fa` 
                  join `{$tbl_ficha_cursos}` `fc` on((`fa`.`id_ficha_curso` = `fc`.`id`))) 
                  join `{$tbl_centros}` `ce` on((`fc`.`id_centro` = `ce`.`id`))) 
                  join `{$tbl_cursos}` `cu` on((`fc`.`id_curso` = `cu`.`id`)))
                  WHERE id_alumno={$id} "
                  . "ORDER BY fecha_inicio";

        $row = $this->_db_->query($SQL);
//        puty($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function nuevo_alumno_auto()
    {
        $nombres = array(
            'María', 'Laura', 'Cristina', 'Marta', 'Sara',
            'Andrea', 'Ana', 'Alba', 'Paula', 'Sandra',
            'David', 'Alejandro', 'Daniel', 'Javier', 'Sergio',
            'Adrián', 'Carlos', 'Pablo', 'Álvaro',
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

        $nombre = $nombres[rand(0, count($nombres))];
        $apellido = $apellidos[rand(0, count($apellidos))];

        $sexo = (rand(0, 9) % 2 === 0) ? 1 : 0;

        $tel = rand(600000000, 799999999);

        $int = rand(1262055681, 1262055681);
        $fecha_nac = date("Y-m-d H:i:s", $int);

        $discapacidad = (rand(0, 99) % 33 === 0) ? 1 : 0;

        $SQL = "INSERT INTO alumnos(dni, nombre, apellidos, sexo, edad1, fechaNac, telefono, discapacidad, fecha_alta)"
                . "VALUES('$nif', '$nombre', '$apellido',$sexo,'0','$fecha_nac','$tel',$discapacidad, now())";
//        put($SQL);exit;
        $this->_db_->query($SQL);
    }
}