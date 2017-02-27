<?php

class acceso_libreModel extends Model {

    private $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = $this->tbl_acceso_libre;
    }

//
//    public function nuevaSesion($campos)
//    {
//
//        $table = $this->tbl_acceso_libre;
//
//        if (in_array('creador', $this->getFields($table))) {
//            $campos[':creador'] = Session::getId();
//        }
//
////construir SQL
//        $str_campos = $str_columnas = '';
//
//        foreach (array_keys($campos) as $k) {
//            $str_campos .= $k . ', ';
//            $str_columnas.=ltrim($k, ":") . ', ';
//        }
//
//        $sql = "INSERT INTO $table (" . rtrim($str_columnas, ', ') . ") VALUES(" . rtrim($str_campos, ', ') . ")"; //el primer campo (null) es el id
////ejecutar consulta
//        $this->_db_->prepare($sql)
//                ->execute($campos);
//
//        $this->_lastID = $this->_db_->lastInsertId(); //guardar ID del registro insertado
//    }

    /**
     * Devuelve los registros de 'acceso_libre' oredenados por fecha_inicio DESC
     * 
     * @return array 
     */
    public function getAllAccesoLibre($id_centro)
    {
        $where = null;
        if ($id_centro) {
            $where = "WHERE id_centro = " . $id_centro;
        } elseif (!Session::esEspecial()) {
            return null;
        }

        $SQL = "SELECT * FROM {$this->table} " . $where . " ORDER BY fecha_inicio DESC";
        $row = $this->_db_->query($SQL);
//        put(__METHOD__);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Finaliza la sesión de acceso libre e inserta curtime() (o fecha_inicio +1.5h) en el registro
     * 
     * @param int $id
     */
    public function finalizarSesionAccesoLibre($id)
    {
        $table = $this->tbl_acceso_libre;
        $idUsuario = Session::getId();

        //Las sesiones de más de 24 horas duran 1.5 horas
        $antigua = $this->_sesionDelDiaAnterior($id);
        if ($antigua) {
            $fechaInicio = $this->_getFechaInicio($id);
            $fecha_fin = strtotime($fechaInicio) + 60 * 60 * 1.5;
            $fecha_fin = date('Y-m-d H:i:s', $fecha_fin);
        } else {
            $fecha_fin = date('Y-m-d H:i:s');
        }

        $campos = array(
            ':fecha_fin' => $fecha_fin
        );
        
        parent::editarRegistro($table, $id, $campos);
    }

    /**
     * Cierra todas las sesiones de acceso libre en el centro indicado
     * @param int $idCentro
     */
    public function cerrarTodas($idCentro)
    {
        $table = $this->tbl_acceso_libre;
        $idUsuario = Session::getId();

        $sql = "SELECT * FROM {$this->tbl_acceso_libre} WHERE fecha_fin IS null";

        if ($idCentro > 0) {
            $sql .= " AND id_centro = {$idCentro}";
        }

        $row = $this->_db_->query($sql);

        $fila = $row->fetchAll(PDO::FETCH_ASSOC);

        for ($index = 0; $index < count($fila); $index++) {
            $this->finalizarSesionAccesoLibre($fila[$index]['id']);
        }
    }

    /**
     * Cierra las sesiones de acceso libre que tengan más de 24 horas de duración en el centro indicado
     * 
     * @param int $centroSeleccionado
     */
    public function cerrarSesionesAnteriores($idCentro)
    {
        $table = $this->tbl_acceso_libre;
        $idUsuario = Session::getId();

        $sql = "SELECT * FROM {$this->tbl_acceso_libre} "
                . "WHERE fecha_fin IS NULL "
                . "AND fecha_inicio < subdate(curdate(), INTERVAL 1 DAY) ";

        if ($idCentro > 0) {
            $sql .= " AND id_centro = {$idCentro}";
        }

        $row = $this->_db_->query($sql);
        $fila = $row->fetchAll(PDO::FETCH_ASSOC);


        for ($index = 0; $index < count($fila); $index++) {
            $this->finalizarSesionAccesoLibre($fila[$index]['id']);
        }
    }

    /**
     * Devuelve los equipos libres para usuarios del centro indicado. Para acceso libre
     * 
     * @param int $id_centro
     * @return array
     */
    public function getEquiposLibres($id_centro)
    {
        $subSQL = "SELECT id_equipo FROM {$this->tbl_acceso_libre}"
                . " WHERE id_centro = {$id_centro} AND fecha_fin IS NULL";

        $sql = "SELECT id, nombre FROM {$this->tbl_equipos} WHERE id_centro = {$id_centro} "
                . "AND id NOT IN ({$subSQL}) ORDER BY nombre";

        $row = $this->_db_->query($sql);

        $equiposLibres = $row->fetchAll(PDO::FETCH_ASSOC);

        //Quitar el equipo del profesor        
        for ($index = 0; $index < count($equiposLibres); $index++) {
            if (stripos($equiposLibres[$index]['nombre'], "PROFESOR") === 0) {
                unset($equiposLibres[$index]);
            }
        }

        return $equiposLibres;
    }

    /**
     * Devuelve el registro correspondiente al alumno del DNI o NUKO si no existe
     * 
     * @param string $dni
     * @return array or null
     */
    public function getIdByDni($dni)
    {
        $sql = "SELECT * FROM {$this->tbl_alumnos} WHERE dni='{$dni}'";

        $row = $this->_db_->query($sql);

        if ($row) {
            return $row->fetch(PDO::FETCH_ASSOC);
        } else {
            return NULL;
        }
    }

    private function _getFechaInicio($id)
    {
        $sql = "SELECT * FROM {$this->tbl_acceso_libre} WHERE id='{$id}'";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['fecha_inicio'];
    }

    public function _sesionDelDiaAnterior($id)
    {
        $sql = "SELECT datediff(now(), fecha_inicio) as ant FROM {$this->tbl_acceso_libre} WHERE id='{$id}'";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['ant'];
    }

}
