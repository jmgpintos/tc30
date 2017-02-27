<?php

class ficha_cursosModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAlumnoByDNI($dni)
    {
        $table = $this->tbl_alumnos;

        $sql = "SELECT * FROM $table WHERE dni = '{$dni}'";

        $row = $this->_db_->query($sql);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getCursoById($cursoID)
    {
        $id = (int) $cursoID;

        $SQL = "SELECT "
                . "fc.id, fc.fecha_inicio fecha, fc.fecha_fin, fc.hora_inicio hora, fc.hora_fin, cu.nombre curso, ce.nombre centro, ce.aforo aforo, ca.nombre categoria, us.nombre profesor "
                . "FROM {$this->tbl_ficha_cursos} fc JOIN {$this->tbl_cursos} cu on fc.id_curso = cu.id "
                . "JOIN {$this->tbl_centros} ce on fc.id_centro = ce.id "
                . "JOIN {$this->tbl_categorias_cursos} ca on cu.id_categoria=ca.id "
                . "JOIN {$this->tbl_usuarios} us on fc.id_profesor = us.id "
                . "WHERE fc.id= $id";
//        vardump($SQL);

        $row = $this->_db_->query($SQL);
//        vardumpy($row);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve los cursos del alumno con id = $id
     * 
     * @param int $id
     */
    public function getAlumnosCurso($id)
    {

        $id = (int) $id;

        $sql = "SELECT `fa`.`id` AS `id_ficha_alumno`,"
                . "`fc`.`id` AS `id_curso`,"
                . "`al`.`id` AS `id_alumno`,"
                . "`al`.`dni` AS `dni`,"
                . "`al`.`nombre` AS `nombre`,"
                . "`al`.`apellidos` AS `apellidos`,"
                . "`al`.`telefono` AS `telefono`,"
                . "`al`.`discapacidad` AS `discapacidad`,"
                . "`al`.`sexo` AS `sexo`,"
                . "`fa`.`id_municipio` AS `id_municipio`,"
                . "`fa`.`codigo_postal` AS `codigo_postal`,"
                . "`fa`.`id_nivel_estudios` AS `id_nivel_estudios`,"
                . "`fa`.`id_ocupacion` AS `id_ocupacion`,"
                . "`fa`.`antiguedad_paro` AS `antiguedad_paro` "
                . "FROM "
                . "`{$this->tbl_ficha_alumnos}` `fa` "
                . "join `{$this->tbl_alumnos}` `al` on `fa`.`id_alumno` = `al`.`id` "
                . "join `{$this->tbl_ficha_cursos}` `fc` on `fa`.`id_ficha_curso` = `fc`.`id` "
                . "WHERE id_ficha_curso=$id "
                . "ORDER BY discapacidad DESC, fa.fecha_creacion";

//        echo "<code>".$sql.';';exit;
        $table = 'alumnos_curso'; //vistaSQL alumnos_curso
        $row = $this->_db_->query($sql);
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

//    public function getAll()
//    {
//        $SQL = "SELECT * FROM ficha_cursos ";
//
//        $row = $this->_db_->query($SQL);
////        puty($SQL);
//
//        return $row->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function getDatosListado($filtro = array())
    {
//        vardump($filtro);
        $claves = array_keys($filtro);
        foreach ($claves as $key) {
            $$key = $filtro[$key];
        }

        $where = array();

        if (!empty($id_curso)) {
            $where [] = " cu.id = '" . $id_curso . "' ";
        }

        if (!empty($id_centro)) {
//            puty($id_centro);
            if ($id_centro == '0') {//0->Centro actual
                $id_centro = $this->getCentroByUserId(Session::getId());
                $where [] = " ce.id = '" . $id_centro . "' ";
            } elseif ($id_centro != '99') {//99->Todos los centros
                $where [] = " ce.id = '" . $id_centro . "' ";
            }
        } else {
            if (!Session::esAdmin()) {
                $id_centro = $this->getCentroByUserId(Session::getId());
                $where [] = " ce.id = '" . $id_centro . "' ";
            }
        }

        if (!empty($desde)) {
            $where [] = " fc.fecha_inicio >= '" . $desde . "' ";
        } else {
            $where [] = " fc.fecha_inicio >= str_to_date('" . FechaHora::lunesAnterior() . "','%Y-%m-%d') ";
//            $where [] = " fc.fecha_inicio >= date_sub(curdate(), INTERVAL 2 MONTH) ";
        }

        if (!empty($hasta)) {
            $where [] = " fc.fecha_fin <= '" . $hasta . "' ";
        }

        $w = implode($where, ' AND ');
        if (!empty($w)) {
            $w = "WHERE " . $w;
        }

        $SQL = "SELECT "
                . "fc.id, fc.fecha_inicio fecha,fc.hora_inicio hora, cu.nombre curso, ce.nombre centro, ca.nombre categoria "
                . "FROM {$this->tbl_ficha_cursos} fc JOIN {$this->tbl_cursos} cu on fc.id_curso = cu.id "
                . "JOIN {$this->tbl_centros} ce on fc.id_centro = ce.id "
                . "JOIN {$this->tbl_categorias_cursos} ca on cu.id_categoria=ca.id ";

        $SQL .= $w;

        $SQL .= " ORDER BY fc.fecha_inicio, fc.hora_inicio";
//        puty($SQL);

        $row = $this->_db_->query($SQL);

        return $row->fetchALL(PDO::FETCH_ASSOC);
    }

    public function getCurso($cursoID)
    {
        $table = $this->tbl_cursos;

        $id = (int) $cursoID;

        $SQL = "SELECT * FROM {$table} WHERE id = {$id}";

        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['nombre'];
    }

    public function getCentro($centroID)
    {
        $table = $this->tbl_centros;

        $id = (int) $centroID;

        $SQL = "SELECT nombre FROM {$table} WHERE id = {$id}";


        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['nombre'];
    }

//
//    public function getTabla($tabla)
//    {
//        $SQL = "SELECT id, nombre FROM {$tabla} ORDER BY nombre";
////        put($SQL);
//
//        $row = $this->_db_->query($SQL);
//
//        return $row->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function getNombreCurso($cursoID)
    {
        $id = (int) $cursoID;

        $table = $this->tbl_cursos;


        $SQL = "SELECT nombre "
                . "FROM {$table} cu JOIN {$this->tbl_ficha_cursos} fc on cu.id = fc.id_curso "
                . "WHERE fc.id = {$id}";

        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['nombre'];
    }

    public function getNombreCentro($cursoID)
    {
        $id = (int) $cursoID;
        $table = $this->tbl_centros;

        $SQL = "SELECT nombre "
                . "FROM {$table} ce JOIN {$this->tbl_ficha_cursos} fc on ce.id = fc.id_centro "
                . "WHERE fc.id = {$id}";

        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['nombre'];
    }

    public function getIdABorrar($idFichaCurso, $idAlumno)
    {
        $table = $this->tbl_ficha_alumnos;

        $SQL = "SELECT id from {$table} where id_ficha_curso = {$idFichaCurso} and id_alumno = {$idAlumno}";

        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['id'];
    }

    public function getDatosMatricula($idAlumno, $idFichaCurso)
    {
        $table = $this->tbl_ficha_alumnos;

        $SQL = "SELECT * FROM {$table} WHERE id_alumno = $idAlumno AND id_ficha_curso = $idFichaCurso";

        $row = $this->_db_->query($SQL);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getCodigoDesempleado()
    {
        $table = $this->tbl_ocupacion;

        $SQL = "SELECT id FROM {$table} WHERE nombre = 'desempleado'";

        $row = $this->_db_->query($SQL);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['id'];
    }

    public function getDatosHoja($filtro)
    {
        $claves = array_keys($filtro);
        foreach ($claves as $key) {
            $$key = $filtro[$key];
        }

        $where = array();

        if (!empty($id_curso)) {
            $where [] = " cu.id = '" . $id_curso . "' ";
        }

        if (!empty($id_centro)) {
//            puty($id_centro);
            if ($id_centro == '0') {//0->Centro actual
                $id_centro = $this->getCentroByUserId(Session::getId());
                $where [] = " ce.id = '" . $id_centro . "' ";
            } elseif ($id_centro != '99') {//99->Todos los centros
                $where [] = " ce.id = '" . $id_centro . "' ";
            }
        } else {
            if (!Session::esAdmin()) {
                $id_centro = $this->getCentroByUserId(Session::getId());
                $where [] = " ce.id = '" . $id_centro . "' ";
            }
        }

        if (!empty($desde)) {
            $where [] = " fc.fecha_inicio >= '" . $desde . "' ";
        } else {
//            $where [] = " fc.fecha_inicio >= date_sub(curdate(), INTERVAL 2 MONTH) ";
        }

        if (!empty($hasta)) {
            $where [] = " fc.fecha_fin <= '" . $hasta . "' ";
        }

        $w = implode($where, ' AND ');
        if (!empty($w)) {
            $w = "WHERE " . $w;
        }


        $SQL = "SELECT "
                . "fc.*, cu.nombre curso, ce.id AS id_centro, ce.nombre centro, ca.nombre categoria, us.nombre AS nom_pro, us.apellidos as ape_pro "
                . "FROM {$this->tbl_ficha_cursos} fc JOIN {$this->tbl_cursos} cu on fc.id_curso = cu.id "
                . "JOIN {$this->tbl_centros} ce on fc.id_centro = ce.id "
                . "JOIN {$this->tbl_categorias_cursos} ca on cu.id_categoria=ca.id "
                . "JOIN {$this->tbl_usuarios} us on fc.id_profesor = us.id ";

        $SQL .= $w;

        $SQL .= " ORDER BY ce.id, fc.fecha_inicio, fc.hora_inicio";
        put($SQL);

        $row = $this->_db_->query($SQL);

        return $row->fetchALL(PDO::FETCH_ASSOC);
    }

//    public function getCentroUsuario($idUsuario)
//    {
//    $id = (int) $idUsuario
//        $table = $this->tbl_usuarios;
//
//        $SQL = "SELECT id_centro FROM {$table} WHERE id = {$id}";
//
//        $row = $this->_db_->query($SQL);
//        
//        $fila = $row->fetch(PDO::FETCH_ASSOC);
//
//        return $fila['id_centro'];
//        
//    }
    public function getAforoCentro($idCentro)
    {
        $id = (int) $idCentro;

        $table = $this->tbl_centros;

        $SQL = " SELECT aforo FROM {$table} WHERE id = {$id}";

        $row = $this->_db_->query($SQL);
        $fila = $row->fetch(PDO::FETCH_ASSOC);


        return $fila['aforo'];
    }

    public function getProfesorByCursoId($idCurso)
    {
        //sacar id_profesor de ficha_cursos
        $table = $this->tbl_ficha_cursos;
        $sql = "SELECT id_profesor FROM {$table} WHERE id = {$idCurso}";
        $row = $this->_db_->query($sql);

        $idProfesor = $row->fetch(PDO::FETCH_ASSOC);

        //Sacar registro profesor
        $table = $this->tbl_usuarios;
        $sql = "SELECT * FROM {$table} WHERE id={$idProfesor['id_profesor']}";
        $row = $this->_db_->query($sql);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getCentros_ajax()
    {
        $table = $this->tbl_centros;
        $paises = $this->_db_->query(
                "SELECT * FROM {$table}"
        );
        return $paises->fetchAll();
    }

    public function getUsuarios_ajax($idCentro)
    {
        $table = $this->tbl_usuarios;
        $usuarios= $this->_db_->query(
                "SELECT * FROM $table WHERE id_centro = {$idCentro}"
        );
        return $usuarios->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUsuariosActivos()
    {
        $table = $this->tbl_usuarios;
        $usuarios= $this->_db_->query(
                "SELECT id, nombre, apellidos, id_centro FROM $table WHERE estado"
        );
        return $usuarios->fetchAll(PDO::FETCH_ASSOC);
    }
}
