<?php

/*
  Define el estilo CSS para el mensaje de la funcion debug
  return -> string
*/  
if(!function_exists('estilo_debug')){
	function estilo_debug($nombre,$nivel,$tipo,$indent){
	  $color="CornflowerBlue";
	  $lh = ($nivel>0)?"margin:0px;":"";
	  if($tipo="array"){
		$lh = ($nivel>0)?"margin:0px;":"margin-bottom:0px;";
		  }
	  $estilo = "style='".MSG_FONT." z-index: 999; line-height:1em; color:$color;${lh}margin-left:${indent}px;width:95%;white-space:normal'";
	  return $estilo;
	}
}

/*
  Muestra un $mensaje de ::ERROR:: en pantalla
  $linea desde la que se llama la función
  
  return -> void
*/
if(!function_exists('error')){
	function error($mensaje,$linea=""){
	  if(MSG_ERROR){
		$cad =  "<pre class='msg-error' style='".MSG_FONT." line-height:1em; background-color:tomato;color:Lavender ;padding:3px;width:85%;'>::ERROR:: $mensaje ";
		$cad .= strlen(trim($linea))?"en linea $linea":"";
		$cad .= "</pre>";
		echo $cad;
		}
	  }
}
  
/*
  Muestra un $mensaje de ::INFO:: en pantalla
  Admite cualquier número de parámetros
  
  return -> void
*/
if(!function_exists('info')){
	function info(){
	  if(MSG_INFO){
		$r = "";
		$cad =  "<pre class='info' style='".MSG_FONT." line-height:1em; background-color:MediumSeaGreen ;color:MintCream; padding:3px;width:85%;white-space:normal;margin:0;'>::INFO:: ";
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
}
/*
  Muestra un mensaje en pantalla
  $nombre -> string
  $valor -> cualquier tipo (excepto objetos)
  $mostrar_tipo -> muestra tipo de dato
  $nivel -> indenta las filas en pantalla (para arrays)
  return -> void
*/
if(!function_exists('debug')){
	function debug($valor,$nombre="",$mostrar_tipo=1,$nivel=0){
	  if(MSG_DEBUG){
		$cab_array = "--ARRAY--"; 
		$cad = ""; 
		$indent = $nivel * 20;

		$tipo = gettype($valor);
		$estilo = estilo_debug($nombre,$nivel,$tipo,$indent);
		$cad .= "<pre class='debug-$nivel' $estilo>";
		$cad .= "<span style='float:left;padding-right:15px;'>::DEBUG:: </span>";  
		
		if($tipo != "array"){
		  //valores para boolean y NULL
		  switch($tipo){
			case "boolean":$valor=$valor?"TRUE":"FALSE";break;
			case "NULL":$valor = "NULO";break;
			}
		  // $sep = ($valor=="" || trim($nombre)=="")?"":":";
		  $cad .= "<span style = 'float:left;display:block;'><strong>$nombre</strong></span>";
		  $cad.= "<span style = 'float:left;padding-left:15px;' >";
		  $cad .= $valor;
		  if ($mostrar_tipo && $valor!=$cab_array) $cad.= " <em>($tipo)</em>";
		  echo $cad."</span></pre>\n<div style='clear:both'></div>";
		}else{
		  //tratamiento de arrays
		  debug($cab_array, $nombre, $mostrar_tipo,$nivel);
		  foreach($valor as $key=>$value){
			debug($value,"[$key]",$mostrar_tipo,$nivel+1);
			}
		  }
		}
	  }
}

if(!function_exists('alerta')){
	function alerta($mensaje){
		$r ="";
		$r .= '<script type="text/javascript">alert("'.$mensaje.'")</script>';
		echo $r;
	}
}
