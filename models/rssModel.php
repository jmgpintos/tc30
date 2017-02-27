<?php

class rssModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getCursosRss()
    {
        $sql = "SELECT cu.nombre curso, cu.descripcion, ce.nombre centro, ce.id id_centro, ce.telefono, ce.direccion, fc.fecha_inicio, fc.fecha_fin, fc.hora_inicio, fc.hora_fin "
                . "FROM {$this->tbl_ficha_cursos} fc "
                . "JOIN {$this->tbl_cursos} cu ON fc.id_curso=cu.id "
                . "JOIN {$this->tbl_centros} ce ON fc.id_centro = ce.id "
                . "WHERE fc.fecha_inicio>curdate() "
                . "ORDER BY fc.fecha_inicio, fc.hora_inicio";

        $row = $this->_db_->query($sql);


        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

}
