<?php

class Model {

    protected $_db_;
    protected $_lastID;
    protected $tbl_alumnos, $tbl_aula_actividades, $tbl_aula_responsables,$tbl_aula_proyectos, $tbl_aula_tipo_actividad, $tbl_aula_usuarios, $tbl_aula_usuarios_actividades, $tbl_acceso_libre, $tbl_categorias_cursos, $tbl_centros, $tbl_cursos, $tbl_equipos, $tbl_ficha_alumnos, $tbl_ficha_cursos, $tbl_incidencias, $tbl_log, $tbl_municipios, $tbl_niveles_estudios, $tbl_ocupacion, $tbl_tipo, $tbl_usuarios, $tbl_borrado;

    public function __construct()
    {
        $this->_db_ = new Database();
        $this->getTableNames();
    }

    public function getSQL($sql)
    {
        $row = $this->_db_->query($sql);

        $rs = $row->fetchAll(PDO::FETCH_ASSOC);

        return $rs;
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

        $SQL = "SELECT * FROM $table ";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recuperar los resultados de una búsqueda
     * 
     * @param string $table 
     * @param array $campos lista de campos y valores del tipo ('nombre_campo' => 'valor_campo')
     * $tipobusqueda int 0 -> '=' 1->'LIKE'
     * @return string SQL de la búsqueda
     */
    public function searchAll($table, array $campos = null, $tipobusqueda = 0)
    {

        $table = $this->getTableName($table);

        $SQL = "SELECT * FROM $table ";
        $where = '';

        if ($campos) {

            foreach ($campos as $k => $v) {

                if ($tipobusqueda == 0) {
                    $where .= "$k = '$v' OR ";
                } else {
                    $where .= "$k LIKE '%$v%' OR ";
                }
            }

            $where = 'WHERE ' . rtrim(rtrim($where, ' AND '), ' OR '); //Quitar el último AND o OR
        }

        $SQL .= $where;

        return $SQL;
    }

    /**
     * Recuperar el registro de la tabla $table con id = $id
     * 
     * @param type $table
     * @param type $index
     * @return array RecorSet con el registro solicitado
     */
    public function getById($table, $index)
    {

        $table = $this->getTableName($table);

        $id = (int) $index;
        $sql = "SELECT * FROM $table WHERE id=$id";
        
//        put($sql);
        $row = $this->_db_->query($sql);

        return $row->fetch(PDO::FETCH_ASSOC);
    }

    public function getNameById($table, $index)
    {

        $usuarios = null;
        if ($table == 'usuarios') {
            $usuarios = true;
        } else {
            $usuarios = false;
        }
        
        $table = $this->getTableName($table);
        $id = (int) $index;
        $sql = "SELECT * FROM $table WHERE id=$id";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);
        if ($usuarios) {
            return $fila;
        } else {
            return $fila['nombre'];
        }
    }

    /**
     * Devuelve el total de filas de la tabla $table
     * 
     * @param type $table
     * @return type int 
     */
//    public function getCount($table) {
//        puty(__METHOD__);
//        
//        $table = $this->getTableName($table);
//        
//        $row = $this->_db_->query("SELECT COUNT(*)cuenta FROM $table");
//        $fila = $row->fetch();
//        
//        return $fila['cuenta'];
//    }

    /**
     * Verifica si existe un registro con los datos dados
     * 
     * @param string $table Tabla en la que busca
     * @param array $campos lista de campos y valores del tipo ('nombre_campo' => 'valor_campo')
     * @return boolean
     */
    public function existeRegistro($table, array $campos)
    {

        $table = $this->getTableName($table);

        $condicion = '';

        foreach ($campos as $k => $v) {
            $condicion .= ltrim($k, ':') . '="' . $v . '" AND ';
        }

        $sql = "SELECT * FROM $table WHERE " . rtrim($condicion, ' AND ') . " LIMIT 1";
//        put($sql);
        $row = $this->_db_->query($sql);

        if ($row->fetch()) {
            return true;
        }

        return false;
    }

    /**
     * Inserta un registro en la tabla $table con los valores de $campos
     * $table es una tabla cuyo primer campo es un id autonumerico
     * 
     * @param string $table tabla en la que se inserta el registro
     * @param array $campos lista de campos y valores del tipo (':nombre_campo' => 'valor_campo')
     */
    public function insertarRegistro($table, array $campos)
    {

        $table = $this->getTableName($table);

        if (in_array('creador', $this->getFields($table))) {
            $campos[':creador'] = Session::getId();
        }

//construir SQL
        $str_campos = $str_columnas = '';

        foreach (array_keys($campos) as $k) {
            $key = ltrim($k, ":");
            $str_campos .= ':' . $key . ', ';
            $str_columnas.=ltrim($k, ":") . ', ';
        }

        $sql = "INSERT INTO $table (" . rtrim($str_columnas, ', ') . ") VALUES(" . rtrim($str_campos, ', ') . ")"; //el primer campo (null) es el id
//        vardump($campos);
//        put($sql);exit;
//ejecutar consulta
        $this->_db_->prepare($sql)
                ->execute($campos);

        $this->_lastID = $this->_db_->lastInsertId(); //guardar ID del registro insertado
        //
//        put($table);
//        put(array_to_str($campos));
//        vardumpy($campos);
        if($table!=$this->tbl_log && $table!=$this->tbl_borrado){
        Log::info('registro insertado', array('tabla' => $table, 'campos' => array_to_str($campos)));
        }
//        puty($this->_lastID);
    }

    /**
     * Actualiza el registro con id = $id en la tabla $table con los valores de $campos
     * 
     * @param string $table tabla en la que se inserta el registro
     * @param int $index PK del registro a editar
     * @param array $campos  lista de campos y valores del tipo (':nombre_campo' => 'valor_campo')
     */
    public function editarRegistro($table, $index, array $campos)
    {
        $table = $this->getTableName($table);

        $id = (int) $index;

//Agregar modificador y fecha_modificacion si la tabla tiene esos campos.
        if (in_array('modificador', $this->getFields($table))) {
            $campos[':modificador'] = Session::getId();
        }
        if (in_array('fecha_modificacion', $this->getFields($table))) {
            $campos[':fecha_modificacion'] = FechaHora::Hoy();
        }

//construir SQL
        $tmp_campos = '';
        foreach (array_keys($campos) as $k) {
            $key = ltrim($k, ':');
            $tmp_campos .= $key . '= :' . $key . ', ';
        }

        $srt_campos = rtrim($tmp_campos, ', ');

        $campos[':id'] = $id; //Añadir campo id a lista campos para execute

        $sql = "UPDATE $table SET " . $srt_campos . " WHERE id = :id";

//        put($sql);
//        var_dump($campos);exit;
        Log::info('registro editado', array('tabla' => $table, 'campos' => array_to_str($campos)));

        $stmt = $this->_db_->prepare($sql);
        return $stmt->execute($campos);
    }

    /**
     * Devuelve un rs con el resultado de la busqueda
     * 
     * @param string $table tabla sobre la que se hace la búsqueda
     * @param array $busqueda array de arrays con del tipo array( array (campo, comparador, texto_que_se_busca),...)
     * @return type
     */
    public function buscarRegistro($table, array $busqueda)
    {

        $table = $this->getTableName($table);

        $sql = 'SELECT * FROM ' . $table;
        $where = '';

        foreach ($busqueda as $campo) {
            $where .= ' ' . $campo[0] . ' ' . $campo[1] . ' "' . $campo[2] . '" ' . ' AND ';
        }
        $sql .= ' WHERE ' . trim($where, ' AND ');

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina el registro con PK $id de la tabla $table
     * 
     * @param string $table Tabla de la que se borra el registro
     * @param int $index PK del registro a borrar
     * 
     * return bool
     */
    public function eliminarRegistro($table, $index)
    {
        $table = $this->getTableName($table);

        $id = (int) $index;

//Datos de  registro borrado
        $reg_borrado = $this->getById($table, $id);

        $r = array_to_str($reg_borrado);

        $tbl_borrado = $this->getTableName('borrado');
        $campos = array(':user' => Session::get('id_usuario'),
            ':tabla' => $table,
            ':descripcion' => $r
        );

//Borrar registro
        $sql = "DELETE FROM $table WHERE id=$id";
//        put(__METHOD__);puty($sql);

        if ($this->_db_->query($sql)) {
//Guardar registro borrado
            $this->insertarRegistro($tbl_borrado, $campos);
            Log::warning('registro borrado', array('tabla' => $table, 'campos' => $r));
            return true;
        } else {
            Log::notice('intento de registro borrado', array('tabla' => $table, 'campos' => $r));
            return false;
        }
    }

    public static function cambiarUltimoAcceso($index)
    {
        $id = (int) $index;

        $table = TABLES_PREFIX . 'usuarios';

        $campos[':id'] = $id;

        $sql = "UPDATE $table SET ultimo_acceso=now() WHERE id = :id";
        $_db = new Database();

        $_db->prepare($sql)
                ->execute($campos);
    }

    function getLastID()
    {
        return $this->_lastID;
    }

    public function getFields($table)
    {

        $table = $this->getTableName($table);

        $rs = $this->_db_->query("SELECT * FROM $table LIMIT 0");
        for ($i = 0; $i < $rs->columnCount(); $i++) {
            $col = $rs->getColumnMeta($i);
            $columns[] = $col['name'];
        }
        return $columns;
    }

    public function getTabla($table, $order=false)
    {
        if(!$order){
            $order='nombre';
        }

        $table = $this->getTableName($table);

        $SQL = "SELECT id, nombre FROM {$table} ORDER BY {$order}";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTablaProfesores()
    {
        $table = $this->getTableName('usuarios');

        $SQL = "SELECT id, apellidos, nombre FROM {$table} WHERE estado ORDER BY apellidos, nombre";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTablaResponsables()
    {
        $table = $this->getTableName('aula_responsables');

        $SQL = "SELECT id, apellidos, nombre FROM {$table} ORDER BY apellidos, nombre";

        $row = $this->_db_->query($SQL);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Agrega el prefijo al nombre de la tabla
     * 
     * @param string $table
     * @return string
     */
    public function getTableName($table)
    {

//        return $table;
        $len_prefix = strlen(TABLES_PREFIX);

        if (substr($table, 0, $len_prefix) == TABLES_PREFIX) {
            return $table;
        } else {
            return TABLES_PREFIX . $table;
        }
    }

    public function getCentroByUserId($id = FALSE)
    {

        if (!$id) {
            $id = Session::getId();
        }

        $sql = "SELECT id_centro FROM {$this->tbl_usuarios} WHERE id = {$id}";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);
//        vardumpy($fila);
        if ($fila['id_centro'] > 0) {
            return $fila['id_centro'];
        } else {
            return null;
        }
    }

    public function getTableNames()
    {
        $this->tbl_alumnos = $this->getTableName('alumnos');
        $this->tbl_acceso_libre = $this->getTableName('acceso_libre');
        $this->tbl_categorias_cursos = $this->getTableName('categorias_cursos');
        $this->tbl_centros = $this->getTableName('centros');
        $this->tbl_cursos = $this->getTableName('cursos');
        $this->tbl_equipos = $this->getTableName('equipos');
        $this->tbl_ficha_alumnos = $this->getTableName('ficha_alumnos');
        $this->tbl_ficha_cursos = $this->getTableName('ficha_cursos');
        $this->tbl_incidencias = $this->getTableName('incidencias');
        $this->tbl_log = $this->getTableName('log');
        $this->tbl_municipios = $this->getTableName('municipios');
        $this->tbl_niveles_estudios = $this->getTableName('niveles_estudios');
        $this->tbl_ocupacion = $this->getTableName('ocupacion');
        $this->tbl_tipo = $this->getTableName('tipo');
        $this->tbl_usuarios = $this->getTableName('usuarios');
        $this->tbl_borrado = $this->getTableName('borrado');

        $this->tbl_aula_actividades = $this->getTableName('aula_actividades');
        $this->tbl_aula_responsables = $this->getTableName('aula_responsables');
        $this->tbl_aula_proyectos = $this->getTableName('aula_proyectos');
        $this->tbl_aula_tipo_actividad = $this->getTableName('aula_tipo_actividad');
        $this->tbl_aula_usuarios = $this->getTableName('aula_usuarios');
        $this->tbl_aula_usuarios_actividades = $this->getTableName('aula_usuarios_actividades');
        
    }

    public function GetDniNino()
    {
        $tabla = $this->tbl_alumnos;

        $sql = "SELECT COUNT(*) as C FROM {$tabla} WHERE dni LIKE 'N%'";

        $row = $this->_db_->query($sql);

        $fila = $row->fetch(PDO::FETCH_ASSOC);

//        put($sql);
        $pad = str_pad(($fila['C'] + 1), 4, '0', STR_PAD_LEFT);
        $numero = 'N' . $pad;
//        put($numero);
        return $numero;
    }

    public function getAllTablesName($db)
    {
        $sql = "SHOW TABLES FROM {$db}";

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_BOTH);
    }

    public function getTableInfo($table, $db)
    {
        $sql = "SHOW COLUMNS FROM  {$db}.{$table}";

        $row = $this->_db_->query($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCreateTable($table, $db)
    {
        $sql = "SHOW CREATE TABLE {$db}.{$table}";

        $row = $this->_db_->query($sql);

//        vardumpy( $row->fetch(PDO::FETCH_NUM)[1]);
        return $row->fetch(PDO::FETCH_NUM);
    }

    public function p()
    {
        $sql = "select distinct al.id, al.p, dni, fechaNac from {$this->tbl_alumnos} al join {$this->tbl_ficha_alumnos} fa on al.id = fa.id_alumno join {$this->tbl_ficha_cursos} fc on fa.id_ficha_curso=fc.id join {$this->tbl_cursos} cu on fc.id_curso=cu.id where  cu.id in (16,35) and year(fechaNac)>2000 and dni not like '72%' order by dni";

        $row = $this->_db_->query($sql);
//        puty($sql);

        return $row->fetchAll(PDO::FETCH_ASSOC);
    }

}
