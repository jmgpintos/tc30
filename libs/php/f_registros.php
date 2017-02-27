<?php
if(!function_exists('borrar_registro')){
	function borrar_registro($config){
		$con = $config['conexion'];
		$tabla = $config['tabla'];
		$array = $config['array'];
	
	if(delete_db($con,$tabla,$array)){
			$a_config= array(
									'mensaje' => $config['x_mensaje'],
									'titulo'	=> $config['x_titulo'],
									'class' => 'exito'
									);
		$_REQUEST['selectCurso']=-1;
		}else{
			$a_config= array(
									'mensaje' => $config['e_mensaje'],
									'titulo'	=> $config[e_titulo],
									'class' => 'error'
									);
		}
		echo dlg_modal($a_config);
	}
}

if(!function_exists('insertar_registro')){
	function insertar_registro($config){
		$con = $config['conexion'];
		$tabla = $config['tabla'];
		$array = $config['array'];
		if(!insert_db($con,$tabla,$array)){
			$a_config= array(
									'mensaje' => $config['e_mensaje'],
									'titulo'	=> $config['e_titulo'],
									'class' => 'error'
									);
			$_REQUEST['selectCurso']=-1;
		}else{
			$a_config= array(
									'mensaje' => $config['x_mensaje'],
									'titulo'	=> $config['x_titulo'],
									'class' => 'exito'
									);
		}
			echo dlg_modal($a_config);
	}
}


if(!function_exists('actualizar_registro')){
	function actualizar_registro($config){
		$con = $config['conexion'];
		$tabla = $config['tabla'];
		$array = $config['array'];
		$where = $config['where'];
		if(!update_db($con,$tabla,$array,$where)){
			$a_config= array(
									'mensaje' => $config['e_mensaje'],
									'titulo'	=> $config[e_titulo],
									'class' => 'error'
									);
		}else{
			$a_config= array(
									'mensaje' => $config['x_mensaje'],
									'titulo'	=> $config['x_titulo'],
									'class' => 'exito'
									);
		}
		echo dlg_modal($a_config);
	}
}