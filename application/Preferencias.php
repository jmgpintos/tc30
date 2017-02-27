<?php

class Preferencias {
  CONST LINES_PER_PAGE = 10;
  CONST THEME = 'light';

  public static function init() {
//si está logueado
    if (Session::get('autenticado')) {
      $prefs = array();
      $idUsuario = Session::getId();

      $db = new Database();
      $model = new Model();

      $table = $model->getTableName('prefs');

      $sql = "SELECT * FROM {$table} WHERE id = {$idUsuario}";

//$row = $this->$db->query($sql);
//$prefs = $row->fetch(PDO::FETCH_ASSOC);
//cargar prefs de usuario
      foreach ($prefs as $k => $v) {
        $$k = $v;
      }

      if (!isset($linesPerPage)) {
        $linesPerPage = self::LINES_PER_PAGE;
      }

      define('LINES_PER_PAGE', $linesPerPage);
    }
  }
  
//  private function getTheme($theme){
//    $themes = array(
//        'light' => 'bootstrap',
//        'dark' => 
//    )
//  }

}
