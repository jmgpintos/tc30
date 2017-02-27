<?php
/*
  Fichero f_array.php
  Funciones para tratar arrays
*/

/*
    Convierte un array en string
    ***NO FUNCIONA con arrays que contengan otros arrays***
    $e -> array
    
    return -> string formado por los elementos del array $e
*/
if(!function_exists('array2string')){
	function array2string($e){
	//array(array(1,2),array(3,4));
	  $r = "";
	  switch(gettype($e)){
		case "array":
		  foreach($e as $c){
			switch(gettype($c)){
			  case "array":$r.=array2string($c);break;
			  case "boolean":$r.=$c?" TRUE ":" FALSE ";break;
			  case "NULL":$r .= " NULO ";break;
			  default:$r.=trim($c)." ";break;
			  }
			}
			break;
		case "boolean":$r.=$e?" TRUE ":" FALSE ";break;
		case "NULL":$r .= " NULO ";break;
		default:$r .= $e;break;
	  }
	  return trim($r);
	 }
}