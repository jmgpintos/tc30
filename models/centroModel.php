<?php

class centroModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll($table = "centros")
    {
        $table = $this->getTableName($table);
        $SQL = "SELECT * FROM $table ORDER BY nombre";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getEquiposPorCentro($id_centro)
    {
        $table = $this->tbl_equipos;
        $sql = "SELECT * FROM {$table} WHERE id_centro = {$id_centro} ORDER BY nombre";
        
        $row = $this->_db_->query($sql);
        
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function p()
    {
        $sql = "select * from information_schema.columns where table_schema = 'test' order by table_name,ordinal_position";
        
        $sql = "SHOW TABLES FROM mvc";
        
        $row =$this->_db_->query($sql);
        
        return $row->fetchAll(PDO::FETCH_ASSOC);
    }
}