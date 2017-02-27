<?php

class cursoModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($table=false)
    {
//        puty(__METHOD__);
        $sql = "select cu.id id,"
                . " cu.nombre nombre,"
                . " cu.especial especial,"
                . " ca.nombre categoria "
                . "from {$this->tbl_cursos} cu "
                . "join {$this->tbl_categorias_cursos} ca on id_categoria = ca.id "
                . "order by ca.id, cu.nombre ;";
                
        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recuperar el registro de la tabla $table con id = $id
     * 
     * @param type $table
     * @param type $index
     * @return array RecorSet con el registro solicitado
     */
    public function getCursoById($index)
    {
        
//        $table= 'cursos';
        $table = $this->tbl_cursos;
//        $table = $this->getTableName($table);
//        
//        $tbl_categorias_cursos = $this->getTableName('categorias_cursos');
        
        $id = (int) $index;
        $sql = "select cu.id id, id_categoria, "
                . "trim(descripcion) descripcion, especial, "
                . "requisitos,"
                . " cu.nombre nombre,"
                . " ca.nombre categoria "
                . "from {$table} cu "
                . "join {$this->tbl_categorias_cursos} ca on id_categoria = ca.id "
                . "WHERE cu.id=$id;";

        $row = $this->_db_->query($sql);
//        vardumpy($row);
//        vardumpy($row->fetch(PDO::FETCH_ASSOC)['id']);
        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getCursos($idCurso)
    {
        $table = $this->tbl_ficha_cursos;

        $sql = "select fc.id id_ficha_curso, "
                . "fc.hora_inicio hora, "
                . "fc.fecha_inicio fecha, "
                . "ce.nombre centro, "
                . "us.nombre profesor "
                . "from {$table} fc "
                . "join {$this->tbl_centros} ce on fc.id_centro=ce.id "
                . "join {$this->tbl_usuarios} us on fc.id_profesor=us.id "
                . "WHERE id_curso={$idCurso} "
                . "ORDER BY fecha DESC";
        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategorias()
    {
        $table = $this->tbl_categorias_cursos;
        
        $sql = "SELECT id, nombre from {$table}";

        $row = $this->_db_->query($sql);
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve los cursos del alumno con id = $id
     * 
     * @param int $id
     */
//    public function get_cursos_alumno($id)
//    {
//        $SQL = "`cursos_alumno` AS
//          select `fa`.`id_alumno` AS `id_alumno`,
//                   `fa`.`id_ficha_curso` AS `id_ficha_curso`,
//                   `fc`.`fecha_inicio` AS `fecha_inicio`,
//                   `fc`.`hora_inicio` AS `hora_inicio`,
//                   `cu`.`nombre` AS `nombre_curso`,
//                   `ce`.`nombre` AS `nombre_centro`,
//                   `fa`.`certificado` AS `certificado` 
//               from (((`ficha_alumnos` `fa` 
//                   join `ficha_cursos` `fc` on((`fa`.`id_ficha_curso` = `fc`.`id`))) 
//                   join `centros` `ce` on((`fc`.`id_centro` = `ce`.`id`))) 
//                   join `cursos` `cu` on((`fc`.`id_curso` = `cu`.`id`))) 
//                   where id_alumno = {$id}";
//
//
//        $id = (int) $id;
//        
////        $table = 'cursos_alumno'; //vistaSQL cursos_alumno
////        $row = $this->_db_->query("SELECT * FROM $table WHERE id_alumno=$id");
//        
//        $row = $this->_db_->query($SQL);
//        return $row->fetchAll(PDO::FETCH_ASSOC);
//    }

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