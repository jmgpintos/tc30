<?php

class incidenciasModel extends Model {

    private $table;
    public function __construct()
    {
        parent::__construct();
        $this->table = $this->tbl_incidencias;
    }

    public function getCentros($idCentro)
    {
        $table = 'centros';
        $table = $this->getTableName($table);
        
        $sql = "SELECT nombre FROM {$table} where id= {$idCentro}";
        
        $row = $this->_db_->query($sql);
        
        $fila = $row->fetch(PDO::FETCH_ASSOC);
        
       return $fila['nombre'];
        
    }

    public function getEquipos($idEquipo)
    {
        $table = 'equipos';
        $table = $this->getTableName($table);
        
        $sql = "SELECT nombre FROM {$table} where id= {$idEquipo}";
        
        $row = $this->_db_->query($sql);
        
        $fila = $row->fetch(PDO::FETCH_ASSOC);
        
       return $fila['nombre'];
        
    }

    public function getTipo($idTipo)
    {
        $table = 'tipo';
        $table = $this->getTableName($table);
        
        $sql = "SELECT nombre FROM {$table} where id= {$idTipo}";
        
        $row = $this->_db_->query($sql);
        
        $fila = $row->fetch(PDO::FETCH_ASSOC);
        
       return $fila['nombre'];
        
    }
    public function getIncidenciasPorCentro($id_centro=false)
    {
        $sql = "SELECT * FROM {$this->table} ";
    
        if ($id_centro){
        $sql .=" WHERE id_centro={$id_centro} ";
        }
        $sql .= "ORDER BY fecha_creacion DESC";
        
        $row = $this->_db_->query($sql);
//        put($sql);
//        vardumpy($row);
        return $row->fetchAll(PDO::FETCH_ASSOC);
//        }else{
//            return null;
//        }
    }
}
