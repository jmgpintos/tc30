<?php

class variosModel extends Model {

    function __construct()
    {
        parent::__construct();
    }
    
    
    /**
     * Recuperar todos los registros de la tabla $table
     * 
     * @param string $table 
     * @return array RecordSet con todos los registros de $table
     */
    public function getAll($table)
    {
        $table = $this->getTableName($table);
        
        $SQL = "SELECT * FROM $table order by nombre";

        $row = $this->_db_->query($SQL);
//        puty($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }
}