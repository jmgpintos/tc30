<?php

  
function nz(&$valor, $reemplazo=''){
  return isset($valor)?$valor:$reemplazo;
  }
  
function startsWith($haystack, $needle){
  return $needle === "" || strpos($haystack, $needle) === 0;
  }

function endsWith($haystack, $needle){
  return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
  }

function linea(){
return "\n";
}

function tab(){
return "\t";
}

/*
  Convierte fecha en texto
	$fecha: fecha a convertir
	$conDia: si =1 -> devuelve también el día de la semana
  
  return -> string
*/
function fechaATexto($fecha,$conDia=-1){
  //Arrays de nombres de días y meses
  $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
  $meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
  
  //Separamos la fecha en día, mes y año
  $array_fecha = explode("-", $fecha);
  $anno = $array_fecha[0]; 
  $mes = $array_fecha[1]; 
  $dia = $array_fecha[2]; 
  
  //Quitar 0 inicial del día
  $dia_texto=$dia;
  if ($dia<10){
    $dia_texto=substr($dia,-1);
    }
  
  //Poner mes en texto 
  $mes_texto=$meses[$mes-1];
  
  //Construimos la cadena de fecha
  $fecha_texto = $dia_texto." de ".$mes_texto." de ".$anno;
  if ($conDia===1){ //Se añade el día de la semana
  $fecha_texto = $dias[date('w')] . ", ".$fecha_texto;
  }
  
  return $fecha_texto;
  }
/*
  Define el estilo CSS para el mensaje de la funcion debug
  return -> string
*/  
function estilo_debug($nombre,$nivel,$tipo,$indent){
  $color="CornflowerBlue";
  $lh = ($nivel>0)?"margin:0px;":"";
  if($tipo="array"){
    $lh = ($nivel>0)?"margin:0px;":"margin-bottom:0px;";
      }
  $estilo = "style='font-family:Gisha,sans-serif;color:$color;${lh}margin-left:${indent}px;'";
  return $estilo;
}


/*
  Muestra un $mensaje de ::ERROR:: en pantalla
  $linea desde la que se llama la función
  
  return -> void
*/
function error($mensaje,$linea=""){
  if(MSG_ERROR){
    $cad =  "<pre style='font-family:Gisha,sans-serif;background-color:tomato;color:Lavender ;padding:3px;'>::ERROR:: $mensaje ";
    $cad .= strlen(trim($linea))?"en linea $linea":"";
    $cad .= "</pre>";
    echo $cad;
    }
  }
  
/*
  Muestra un $mensaje de ::INFO:: en pantalla
  Admite cualquier número de parámetros
  
  return -> void
*/
function info(){
  if(MSG_INFO){
    $r = "";
    $cad =  "<pre style='font-family:Gisha,sans-serif; background-color:MediumSeaGreen   ;color:MintCream; padding:3px;'>::INFO:: ";
    $args = func_num_args();
    for($i = 0; $i <$args;$i++){
      $arg = func_get_arg($i);
      switch(gettype($arg)){
        case "array": $arg = array2string($arg);break;
        case "boolean": $arg = $arg?"TRUE":"FALSE";break;
        case "NULL":$arg="NULL";break;
        case "string": $arg = trim($arg);
        }
      $r .= $arg. " ";
      }
    $cad .= trim($r)."</pre>";
    echo $cad.linea();
    }
  }
  
function array2string($e){
  $r = "";
  switch(gettype($e)){
    case "array":
      foreach($e as $cad){
        $r .= trim($cad)." ";
        }
        break;
    case "string":
      $r = $e;break;
  }
  // return trim($r);
  return implode(" ",$e);
 }

/*
  Muestra un mensaje en pantalla
  $nombre -> string
  $valor -> cualquier tipo (excepto objetos)
  $mostrar_tipo -> muestra tipo de dato
  $nivel -> indenta las filas en pantalla (para arrays)
  return -> void
*/
function debug($valor,$nombre="",$mostrar_tipo=1,$nivel=0){
if(MSG_DEBUG){
  $cab_array = "--ARRAY--"; $cad = ""; $indent = $nivel * 20;

  $tipo = gettype($valor);
  $estilo = estilo_debug($nombre,$nivel,$tipo,$indent);
  $cad .= "<pre $estilo>::DEBUG:: ";  
  if($tipo != "array"){
    //valores para boolean y NULL
    switch($tipo){
      case "boolean":$valor=$valor?"TRUE":"FALSE";break;
      case "NULL":$valor = "NULO";break;
      }
    $cad.= "<strong>$nombre";
    $sep = ($valor=="" || trim($nombre)=="")?"":":";
    $cad .= $sep."</strong> ".$valor;
    if ($mostrar_tipo) {
      $cad.= " <em>($tipo)</em>";
    }
    echo $cad."</pre>\n";
  }else{
    //tratamiento de arrays
    debug($cab_array, $nombre,$mostrar_tipo,0,$nivel);
    foreach($valor as $key=>$value){
      debug("indice:$key",$value,$mostrar_tipo,$nivel+1);
      }
    }
  }
}

/*
  Pone en mayúscula la primera letra de cada palabra en $cad
  return -> string.
*/
function capitalizar($cad){
  $tipo = gettype($cad);
  switch($tipo){
    case "array":
      foreach($cad as $cadena){
        $r[]=capitalizar($cadena);
        }
      break;
    case "string":
      $largo = strlen(trim($cad));
      if($largo){
          $separadores=Array(" ","-", "(", "[");
          $particulas=Array("de", "da", "del", "y", "o", "la", "de los", "d'", "das", "al", "no",  "en", "ni", "por", "ser", "e");
          $cad = strtolower($cad);
          $r = strtoupper(substr($cad,0,1)); //Primera letra
          for($i=1;$i<$largo;$i++){
            if(in_array($cad[$i-1],$separadores)){
              $r.=strtoupper($cad[$i]); //Si está detrás de un separador, se pone en mayúsculas
              }else{
                $r.=$cad[$i]; //Si no, se deja en minúsculas
                }
            }
          //Está cada palabra capitalizada, ahora hay que poner en minúscula las partículas
          $r = explode(" ",$r);
          $largo = count($r);
          for($i=0;$i<$largo;$i++){
            if(in_array(strtolower($r[$i]),$particulas)){
              $r[$i] = strtolower($r[$i]);
              }
            }
          $r = implode(" ",$r);
        }
        break;
      case "boolean":$r=$cad?"TRUE":"FALSE";break;
      case "NULL":$r = "NULO";break;
      default:
        $r=$cad;
        break;
    }
    return $r;
  }
  
/*
  Conecta a una base de datos según la configuración definida por las constantes DB_
*/
  function conectar_db()  {
  $conn = mysqli_connect(
                DB_HOST,
                DB_USER,
                DB_PASSWORD,
                DB_DATABASE,
                DB_PORT);
  return $conn;
  }

  include_once("config.php");
$conn = conectar_db();
if (!($conn)) {
  die('No se puede conectar con el servidor de MySQL: ' . mysqli_connect_error());
}

$result = mysqli_query($conn, 'SELECT `Id_LugarNac`, `LugarNac` FROM lugarsnac ORDER BY LugarNac ');
$mun= array();
  info(array("Lista de Municipios",5));
  debug(array("Lista de Municipios",5));
  debug(5,"Lista de Municipios");
  error("Lista de Municipios");
  debug(5,"Lista de Municipios");
  info("Lista de Municipios");
  $n=0;
while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) != NULL) {
  // $mun[] = $row['LugarNac'];
  $mun = $row['LugarNac'];
  // $largo = strlen($row['LugarNac']);
  // $impar = ($largo%2==0);
  // info("Municipio", capitalizar($row['LugarNac']),NULL,$largo,$impar);
  $n++;
  info("Municipio $n: ", capitalizar($mun));
  // debug(capitalizar($mun),"Municipio $n:" );
  error("Municipio $n: ". capitalizar($mun));
}
  // debug("PRUEBA: ", capitalizar("ÁÉÍÓÚ áéíóú ÑÑÑ ñññ"));
  // debug("PRUEBA: ", capitalizar(NULL));
  // debug("PRUEBA ARRAY: ", capitalizar(array("uno",2,NULL,array("dos palabras",TRUE,FALSE),"tres")));
  
  // error("Mensaje de error",__LINE__);
  // error("Mensaje de error sin linea");
  // debug("Municipios", $mun,0);
  // natcasesort($mun);
  // debug("NATCASESORT", $mun,1);
  // asort($mun);
  // debug("ASORT", capitalizar($mun),1,1);
  // echo nz($no,"NULL");
  // arsort($mun);
  // debug("ARSORT", $mun,0,1);
  // rsort($mun);
  // debug("RSORT", $mun,0,1);
  // shuffle($mun);
  // debug("SHUFFLE", $mun,1,1);
  // debug("prueba",152,0,1);
  // debug("prueba",152,1,1);
  // debug("prueba",152,D_ERROR,1);
  // debug("prueba",152,D_DEBUG,1);
mysqli_free_result($result);
mysqli_close($conn);

// debug( "get_defined_constants",get_defined_constants());