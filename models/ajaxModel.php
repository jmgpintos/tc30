<?php

class ajaxModel extends Model {

    public function __construct()
    {
        parent::__construct();
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

    public function insertarCiudad($ciudad, $pais)
    {
//        $sql = "INSERT INTO ciudades VALUES(null,'{$ciudad}','{$pais}')";
//        puty($sql);
        $this->_db_->query(
                "INSERT INTO ciudades VALUES(null,'{$ciudad}','{$pais}')"
        );
    }
}