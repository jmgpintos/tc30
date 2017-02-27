<?php

class logModel extends Model {

  private $table;

  public function __construct() {
    parent::__construct();
    $this->table = $this->tbl_log;
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

        $SQL = "SELECT * FROM $table order by id DESC";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }
}
