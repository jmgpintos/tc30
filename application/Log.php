<?php

class Log {

  const EMERG = 0;
  const ALERT = 1;
  const CRIT = 2;
  const ERROR = 3;
  const WARNING = 4;
  const NOTICE = 5;
  const INFO = 6;
  const DEBUG = 7;

  public static function emerg($message, array $context = array()) {
    self::_log(self::EMERG, $message, $context);
  }

  public static function alert($message, array $context = array()) {
    self::_log(self::ALERT, $message, $context);
  }

  public static function crit($message, array $context = array()) {
    self::_log(self::CRIT, $message, $context);
  }

  public static function error($message, array $context = array()) {
    self::_log(self::ERROR, $message, $context);
  }

  public static function warning($message, array $context = array()) {
    self::_log(self::WARNING, $message, $context);
  }

  public static function notice($message, array $context = array()) {
    self::_log(self::NOTICE, $message, $context);
  }

  public static function info($message, array $context = array()) {
    self::_log(self::INFO, $message, $context);
  }

  public static function debug($message, array $context = array()) {
    if (DEBUG) {
      self::_log(self::DEBUG, $message, $context);
    }
  }

  public static function getNivel($id) {
    $nivel = false;

    switch ($id) {
      case 7:
        $nivel = 'DEBUG';
        break;
      case 6:
        $nivel = 'INFO';
        break;
      case 5:
        $nivel = 'NOTICE';
        break;
      case 4:
        $nivel = 'WARNING';
        break;
      case 3:
        $nivel = 'ERROR';
        break;
      case 2:
        $nivel = 'CRIT';
        break;
      case 1:
        $nivel = 'ALERT';
        break;
      case 0:
        $nivel = 'EMERG';
      default:
        break;
    }
    return $nivel;
  }

  private static function _log($level, $message, array $context = array()) {
    //Abrir conexión    
    $logModel = new Model();

    //establecer valores
    $metodo = self::GetCallingMethodName();

    if (array_key_exists('tabla', $context)) {
      $tabla = $context['tabla'];
      unset($context['tabla']);
    } else {
      $tabla = '';
    }

    $desc = array_to_str($context);

    //escribir log
    $table = 'log';
    $campos = array(
        'nivel' => $level,
        'id_usuario' => Session::getId(), //Ojo si no existe id (ponerlo antes de llamar a log)
        'ip' => $_SERVER['REMOTE_ADDR'],
//        'equipo' => gethostname(),
        'equipo' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
        'metodo' => $metodo,
        'tabla' => $tabla,
        'mensaje' => $message,
        'contexto' => $desc
    );

    $logModel->insertarRegistro('log', $campos);

    //cerrar conexión
    unset($logModel);
  }

  public static function GetCallingMethodName() {
//        put(__METHOD__);
    $trace = debug_backtrace();
//        var_dump($trace);

    for ($index = 0; $index < count($trace); $index++) {
//            vardump($trace[$index]);
//            put(stripos($trace[$index]['class'],'log'));
      if ($trace[$index]['class'] != 'Log') {
//                put('DENTRO');
        $metodo = $trace[$index]['class'] . '::' . $trace[$index]['function'];
        break;
      }
    }
    return $metodo;
  }

}
