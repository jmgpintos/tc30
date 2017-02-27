<?php

class estadisticasmodel extends Model {

  private $_nombreSQL;
  private $_fechas;
  private $_edad;
  private $_caseFecha;

  function __construct()
  {
    parent::__construct();
    $this->init();
  }

  function init()
  {
    $this->_fechas = '';
    $this->_edad = " date_format(from_days(datediff(curdate(),al.fechaNac)),'%y')+0 ";
    $this->_caseFecha = "(CASE WHEN {$this->_edad} BETWEEN 0 AND 24 THEN '/Menor de 25' "
            . " WHEN {$this->_edad} BETWEEN 25 AND 34 THEN 'De 25 a 35'"
            . " WHEN {$this->_edad} BETWEEN 35 AND 44 THEN 'De 35 a 45'"
            . " WHEN {$this->_edad} BETWEEN 45 AND 54 THEN 'De 45 a 55'"
            . " WHEN {$this->_edad} BETWEEN 55 AND 64 THEN 'De 55 a 65'"
            . " WHEN {$this->_edad} BETWEEN 65 AND 125 THEN 'Mayor de 65' END) AS Edades";
  }

  public function setFechas($fechaInicio, $fechaFin)
  {
    $this->_fechas = "AND fc.fecha_inicio >= '" . $fechaInicio . "' "
            . " AND fc.fecha_inicio <= '" . $fechaFin . "'";
  }

  /*
    // 01 ALUMNOS POR TELECENTRO (+%)

    SELECT nombreCentro AS 'centro', count(*) AS 'Alumnos', count(*) / (
    SELECT count(nombrecentro)  FROM tc30_ficha_alumnos  fa
    JOIN tc30_fichacurso  fc ON  fa.id_ficha_curso= fc.id
    JOIN tc30_centro ON idCentro = Centro_idCentro
    WHERE Municipio_idMunicipio is not null {$this->_fechas} ) * 100 AS '%'
    FROM tc30_ficha_alumnos
    JOIN tc30_fichacurso ON idFichaCurso = fichaCurso_idFichaCurso
    JOIN tc30_centro ON idCentro = Centro_idCentro
    WHERE Municipio_idMunicipio is not null {$this->_fechas}
    GROUP by nombreCentro with rollup

    $titulo01 = 'Centros';
   * */

  public function sqlAlumnosXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;
    $sql = "SELECT ce.nombre AS 'centro', count(*) AS 'Alumnos', count(*) / ("
            . " SELECT count(ce.nombre)  FROM {$this->tbl_ficha_alumnos}  fa "
            . " JOIN {$this->tbl_ficha_cursos}  fc ON  fa.id_ficha_curso= fc.id "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro "
            . " WHERE id_municipio is not null {$this->_fechas} ) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro "
            . " WHERE id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXProcedencia()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT mu.nombre AS 'Municipio', count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(mu.nombre) "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_municipios} mu ON mu.id= fa.id_municipio "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_municipios} mu ON mu.id= fa.id_municipio "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by mu.nombre WITH ROLLUP";


    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCurso()
  {

    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT cu.nombre AS 'Curso', count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(cu.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id = fc.id_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) *100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id = fc.id_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by cu.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCursoXTelecentro()
  {

    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT ce.nombre AS 'Centro', cu.nombre AS 'Curso', "
            . " count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(cu.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id= fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id= fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, cu.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCursoXSexo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT cu.nombre AS 'Curso', "
            . " (CASE al.sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS 'Sexo', "
            . " count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(cu.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_alumnos} al ON al.id = fa.id_alumno "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_alumnos} al ON al.id = fa.id_alumno "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by cu.nombre, al.sexo";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCursoXSexoXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT ce.nombre AS 'Centro', cu.nombre AS 'Curso', "
            . "(CASE sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS 'Sexo', "
            . "count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(cu.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_alumnos} al ON al.id = fa.id_alumno "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_alumnos} al ON al.id = fa.id_alumno "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, cu.nombre, al.sexo";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEdad()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT "
            . "{$this->_caseFecha}, "
            . " count(*) AS Alumnos, "
            . " count(*) / ("
            . " SELECT count(al.id) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio IS NOT NULL AND al.fechaNac!='0000-00-00' {$this->_fechas} "
            . " GROUP BY Edades ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCursoXEdad()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT "
            . " cu.nombre, "
            . " {$this->_caseFecha}, "
            . " count(*) AS Alumnos, "
            . " count(*) / ("
            . " SELECT count(al.id) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id=fc.id_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id=fc.id_curso "
            . " WHERE fa.id_municipio IS NOT NULL AND al.fechaNac!='0000-00-00' {$this->_fechas} "
            . " GROUP BY cu.nombre, Edades ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXCentroXCursoXEdad()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT "
            . " ce.nombre, cu.nombre, "
            . " {$this->_caseFecha}, "
            . " count(*) AS Alumnos, "
            . " count(*) / ("
            . " SELECT count(al.id) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id=fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id=fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio IS NOT NULL AND al.fechaNac!='0000-00-00' {$this->_fechas} "
            . " GROUP BY ce.nombre, cu.nombre, Edades ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEdadXCentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT "
            . " ce.nombre, "
            . " {$this->_caseFecha}, "
            . " count(*) AS Alumnos, "
            . " count(*) / ("
            . " SELECT count(al.id) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio IS NOT NULL AND al.fechaNac!='0000-00-00' {$this->_fechas} "
            . " GROUP BY ce.nombre, Edades ";


    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXSexo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT (CASE al.sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, "
            . " count(*) AS 'Alumnos', "
            . " count(*) / (SELECT count(al.sexo) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by sexo ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXSexoXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT (CASE al.sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, ce.nombre AS 'Centro', "
            . " count(*) AS 'Alumnos', "
            . " count(*) / (SELECT count(al.sexo) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by sexo, ce.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEstudio()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "  SELECT es.nombre AS 'Estudios', count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(es.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by es.nombre";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEstudiosXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "  SELECT ce.nombre AS 'Centro', es.nombre AS 'Estudios', count(*) AS 'Alumnos', count(*) / ( "
            . " SELECT count(es.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, es.nombre";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacion()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT oc.nombre AS 'Ocupación', count(*) AS 'Total', count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . "FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by oc.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacionXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT ce.nombre AS 'Centro', oc.nombre AS 'Ocupación', count(*) AS 'Total', count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . "FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id=fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, oc.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacionXEstudios()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT es.nombre AS 'Estudios', oc.nombre AS 'Ocupación', count(*) AS 'Total', count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . "FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by es.nombre, oc.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacionXEstudiosXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT ce.nombre AS 'Centro', es.nombre AS 'Estudios', oc.nombre AS 'Ocupación', count(*) AS 'Total', count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id= fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . "FROM {$this->tbl_ficha_alumnos} fa"
            . " JOIN {$this->tbl_alumnos} al ON al.id= fa.id_alumno"
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id= fc.id_centro "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, es.nombre, oc.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEstudiosXSexo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT (CASE sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, "
            . " es.nombre AS Estudios, count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(es.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by sexo, es.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXEstudiosXSexoXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT es.nombre AS Estudios, "
            . " (CASE sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, "
            . " ce.nombre AS 'Centro', count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(es.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso"
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_niveles_estudios} es ON es.id= fa.id_nivel_estudios "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso"
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by sexo, es.nombre, ce.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacionXSexo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT oc.nombre AS Ocupacion, "
            . " (CASE sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, "
            . " count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by oc.nombre, sexo WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXOcupacionXSexoXCentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT oc.nombre AS Ocupacion, "
            . " (CASE sexo when 'M' then 'Mujer' when 'H' then 'Hombre' END) AS Sexo, "
            . " ce.nombre AS 'Centro', count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(oc.nombre) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso"
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_alumnos} al ON al.id=fa.id_alumno "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id = fa.id_ficha_curso"
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by oc.nombre, sexo, ce.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXAntiguedadParo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT "
            . " (CASE WHEN antiguedad_paro BETWEEN 0 AND 1 THEN '0. De 0 a 1 mes' "
            . " WHEN antiguedad_paro BETWEEN 2 AND 3 THEN '1. De 2 a 3 meses' "
            . " WHEN antiguedad_paro BETWEEN 4 AND 6 THEN '2. De 4 a 6 meses' "
            . " WHEN antiguedad_paro BETWEEN 7 AND 12 THEN '3. De 7 a 12 meses' "
            . " WHEN antiguedad_paro BETWEEN 13 AND 24 THEN '4. De 13 a 24 meses' "
            . " WHEN antiguedad_paro > 25 THEN '5. Mas de 25 meses' END) 'Tiempo_en_paro',  "
            . " count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(antiguedad_paro) FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id = fc.id_curso"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " and oc.nombre= 'Desempleado') * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ocupacion} oc ON oc.id= fa.id_ocupacion "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id = fc.id_curso"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " and oc.nombre = 'Desempleado' "
            . " GROUP by Tiempo_en_paro";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlCertificadosEmitidos()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT 'Certificados' AS '',' ', count(fecha_certificado) AS 'Certificados Emitidos' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso"
            . " WHERE fa.id_municipio is not null {$this->_fechas} ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXTipoDeCurso()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT ca.nombre AS Categoria, count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(ca.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_categorias_cursos} ca ON ca.id= cu.id_categoria "
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_categorias_cursos} ca ON ca.id= cu.id_categoria "
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ca.nombre WITH ROLLUP ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXTipoDeCursoXTelecentro()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT ca.nombre AS Categoria, ce.nombre AS 'Centros', count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(ca.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_categorias_cursos} ca ON ca.id= cu.id_categoria "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_categorias_cursos} ca ON ca.id= cu.id_categoria "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ca.nombre, ce.nombre WITH ROLLUP ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlAlumnosXTelecentroXProcedencia()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = "SELECT ce.nombre AS 'Centros', mu.nombre AS 'Municipio', "
            . " count(*) AS Alumnos, count(*) / ( "
            . " SELECT count(mu.nombre)  FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro "
            . " JOIN {$this->tbl_municipios} mu ON mu.id = fa.id_municipio"
            . " WHERE fa.id_municipio is not null {$this->_fechas}) * 100 AS '%' "
            . " FROM {$this->tbl_ficha_alumnos} fa "
            . " JOIN {$this->tbl_ficha_cursos} fc ON fc.id= fa.id_ficha_curso "
            . " JOIN {$this->tbl_cursos} cu ON cu.id= fc.id_curso "
            . " JOIN {$this->tbl_centros} ce ON ce.id = fc.id_centro"
            . " JOIN {$this->tbl_municipios} mu ON mu.id = fa.id_municipio"
            . " WHERE fa.id_municipio is not null {$this->_fechas} "
            . " GROUP by ce.nombre, mu.nombre WITH ROLLUP ";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlCursosXAnyoXTipo()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT cu.nombre AS 'Curso', count(cu.nombre) AS 'Total'"
            . " FROM {$this->tbl_ficha_cursos} fc "
            . " JOIN {$this->tbl_cursos} cu ON cu.id=fc.id_curso "
            . " WHERE NOT cu.especial  {$this->_fechas} "
            . " GROUP BY cu.nombre WITH ROLLUP";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

  public function sqlCursosXProfesor()
  {
    $this->_nombreSQL = __METHOD__;

    $sql = " SELECT CONCAT(us.apellidos, ', ',us.nombre) AS 'Profesor', "
            . " count(fc.id) AS 'Cursos' FROM {$this->tbl_ficha_cursos} fc "
            . " JOIN {$this->tbl_usuarios} us ON us.id = fc.id_profesor "
            . " WHERE true {$this->_fechas} "
            . " GROUP BY us.id ORDER BY CONCAT(us.apellidos, ', ',us.nombre)";

    return array($sql, parent::getSQL($sql), $this->_nombreSQL);
  }

}