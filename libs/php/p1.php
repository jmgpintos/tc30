<?php
include("f_includes.php");

/* PRUEBAS */  

$conn = conectar_db();
if (!($conn)) {
  die('No se puede conectar con el servidor de MySQL: ' . mysqli_connect_error());
}

$result = mysqli_query($conn, 'SELECT `Id_LugarNac`, `LugarNac` FROM lugarsnac ORDER BY LugarNac ');
$array = array(1,2,3);

$mun= array();
function random_array($e){ 
  $car = "abcedghijklmnopqrstuvwxyz";
  $car .= strtoupper($car);
  $car .= "0123456789";
  $largo= strlen($car)-1;
  $array=array();
  for($i=0;$i<$e;$i++){
    $rand = rand(1,10);
    for($j=0;$j<$rand;$j++){
      $rand2 = rand(1,10);
      $rand1 = rand(1,$largo);
      $array[$i][$j]=$car[$rand1];
      for($k=0;$k<$rand2;$k++){
        $rand1 = rand(1,10);
        $array[$i][$j].=$car[$rand1];
      }
    }
  }
  return $array;
  }
  $array = array('foo', 'bar', 'prueba',array(1,2));

//Array to String
$string = serialize($array);
debug($string);

//String to array
$array = unserialize($string);
debug($array);


  $pr=array(TRUE,0,array(NULL, "cadena",FALSE,0));
  debug(array2string($pr));
   // $array = array(array(1,2),array(3,4));
   $array=random_array(25);
   debug(array2string($array),"FINAL");
   $array=random_array(2);
   debug(array2string($array),"FINAL");
   $array=random_array(3);
   debug(array2string($array),"FINAL");
   $array=random_array(15);
   debug(array2string($array),"FINAL");
   $array=random_array(8);
   debug(array2string($array),"FINAL");
   $config = array(
                'host' => DB_HOST,
                'user' => DB_USER,
                'password' => DB_PASSWORD,
                'database' => DB_DATABASE,
                'port' => DB_PORT);
   debug($config);
  $n=0;
// while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) != NULL) {
  // $mun[] = $row['LugarNac'];
  // $mun = $row['LugarNac'];
  // $largo = strlen($row['LugarNac']);
  // $impar = ($largo%2==0);
  // info("Municipio", capitalizar($row['LugarNac']),NULL,$largo,$impar);
  // $n++;
  // debug(capitalizar($mun),"Municipio $n:" );
  // error("Municipio $n: ". capitalizar($mun));
// }
  
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