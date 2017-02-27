<?php

class aula_actividadesModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllActividades()
    {
        $table = $this->tbl_aula_actividades;

        $sql = "SELECT aa.id, aa.nombre nombre, aa.id_responsable, ata.nombre tipo_actividad, fecha_inicio, fecha_fin, hora_inicio, hora_fin, aa.descripcion"
                . " FROM {$table} aa"
                . " JOIN {$this->tbl_aula_tipo_actividad} ata ON aa.id_tipo=ata.id";

//                put($sql);

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActividad($idActividad)
    {
        $table = $this->tbl_aula_actividades;

        $sql = "SELECT aa.id, aa.nombre nombre, ata.nombre tipo_actividad, fecha_inicio, fecha_fin, hora_inicio, hora_fin, aa.descripcion"
                . " FROM {$table} aa "
                . " JOIN {$this->tbl_aula_tipo_actividad} ata ON aa.id_tipo=ata.id "
                . " WHERE aa.id={$idActividad}";

//                put($sql);

        $row = $this->_db_->query($sql);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getTipoActividades()
    {
        $table = $this->tbl_aula_tipo_actividad;

        $sql = "SELECT id, nombre FROM {$table}";

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNombreActividad($idActividad)
    {
        $table = $this->tbl_aula_actividades;

        $sql = "SELECT nombre FROM {$table} WHERE id = {$idActividad}";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['nombre'];
    }

    public function getUsuariosActividad($idActividad)
    {
        $table = $this->tbl_aula_usuarios_actividades;

        $sql = "SELECT * FROM {$table} WHERE id_actividad = {$idActividad}";
//        puty($sql);

        $row = $this->_db_->query($sql);
        $fila = $row->fetchAll(PDO::FETCH_ASSOC);
//        vardump($fila);

        if (count($fila) > 0) {

            for ($i = 0; $i < count($fila); $i++) {

                $usuarios[] = $fila[$i]['id_usuario'];
            }
//            vardump($usuarios);

            $idUsuarios = implode(',', $usuarios);

            $table = $this->tbl_aula_usuarios;

            $sql = "SELECT * FROM {$table} WHERE id IN ({$idUsuarios})";
//            puty($sql);

            $row = $this->_db_->query($sql);

            return $row->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function getUsuarioByDNI($dni)
    {
        $table = $this->tbl_aula_usuarios;

        $sql = "SELECT * FROM {$table} WHERE dni = '{$dni}'";

        $row = $this->_db_->query($sql);


        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function inscribirUsuarioEnActividad($idActividad, $idUsuario)
    {
        $table = $this->tbl_aula_usuarios_actividades;

        $campos = array(
            'id_usuario' => $idUsuario,
            'id_actividad' => $idActividad
        );
        $sql = "SELECT * FROM {$table} "
                . "WHERE id_usuario = {$idUsuario} AND id_actividad = {$idActividad}";

        $row = $this->_db_->query($sql);

        $existe = $row->fetch(PDO::FETCH_ASSOC);
        if (!$existe) {
            parent::insertarRegistro($table, $campos);
            return true;
        }else{
            return false;
        }
    }

    public function getIdABorrar($idActividad, $idUsuario)
    {
        
        $table = $this->tbl_aula_usuarios_actividades;

        $sql = "SELECT id from {$table} where id_actividad = {$idActividad} and id_usuario = {$idUsuario}";
        
//      put(__METHOD__);  put($sql);

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

        return $fila['id'];
    }
    
    public function getDatosInscripcion($idActividad,$idUsuario)
    {
        $table = $this->tbl_aula_usuarios_actividades;
        $tbl_usuarios = $this->tbl_aula_usuarios;
        $tbl_actividades = $this->tbl_aula_actividades;
        $tbl_tipos = $this->tbl_aula_tipo_actividad;
        
        $sql = "SELECT aua.*, au.nombre, au.apellidos, aa.nombre nombre_actividad, fecha_inicio, fecha_fin, hora_inicio, hora_fin, ata.nombre tipo_actividad"
                . " FROM {$table} aua"
        . " JOIN {$tbl_usuarios} au ON au.id=aua.id_usuario "
        . " JOIN {$tbl_actividades} aa ON aa.id=aua.id_actividad "
        . " JOIN {$tbl_tipos} ata ON aa.id_tipo=ata.id "
        . " WHERE id_actividad = {$idActividad} AND id_usuario= {$idUsuario}";
        
//        puty($sql);
        $row = $this->_db_->query($sql);
        
       return $row->fetch(PDO::FETCH_ASSOC);
    }
}
