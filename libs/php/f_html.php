<?php

if(!function_exists('html_header')){

	function html_header($titulo,$dir=""){
		// debug($dir,"dir");
		
		$r = '<!DOCTYPE html >';
		$r .= linea();
		$r .= '<head>';
		$r .= linea().tab();
		$r .= "<title>$titulo</title>";
		$r .= linea().tab();
		$r .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		$r .= linea().tab();
		$r .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
		$r .= linea().tab();
		$r .= '<link href="imagenes/iconoAgencia.ico" rel="shortcut icon" type="image/x-icon">';
		$r .= linea().tab();
		$r .= '<link href="'.$dir.'/estilos/checkbutton.css" rel="stylesheet" type="text/css" />';
		$r .= linea().tab();
		$r .= '<link href="'.$dir.'/estilos/estilos1.css" rel="stylesheet" type="text/css" />';
		$r .= linea().tab();
		$r .= '<link href="'.$dir.'/estilos/estilo.css" rel="stylesheet" type="text/css" />';
		$r .= linea().tab();
		$r .= '<link href="'.$dir.'/estilos/estilo.css" rel="stylesheet" type="text/css" />';
		$r .= linea();
		$r .= '</head>';
		$r .= linea().tab();
		$r .= '<body>';
		$r .= linea();
		return $r;
		}
}

if(!function_exists('dlg_modal')){
	function dlg_modal($a_config){
		// debug("XXXXXXXXXX");
		// $mensaje, $titulo="", $class=""){
			// $a_config = init_dlg_modal($a_config);
			// debug($a_config);die;
		$mensaje = nz($a_config['mensaje']);
		$titulo = nz($a_config['titulo']);
		$class = nz($a_config['class']);
		$class = 'dlg-'.$class;
		// <a href="#openModal">Open Modal</a><br/>
			
			$r="";
			$r .=  '<div id="openModal" class="modalDialog">';
			$r .=  linea().tab();
			$r .=  '<div>';
			$r .=  linea().tab();
			$r .=  '<a href="'.$_SERVER['HTTP_REFERER'].'" title="Close" class="close">X</a>';
			$r .=  linea().tab();
			$r .=  "<div id='titulo'>$titulo</div>";
			$r .=  linea().tab();
			$r .=  "<div class='".$class." mensaje'>$mensaje";
			$r .=  linea();
			$r .=  '<div id="actions" style="text-align: center;">';
			// $r .= '<input name="cerrar" type="submit" class="btn100 btn_verde" value="Cerrar" formnovalidate/>';
			$r .= '<a id="btnVolver" class="btn_verde btn100" href="'.$_SERVER['HTTP_REFERER'].'">Volver</a>';
			$r .= '</div>';
			$r .= '</div>';
			$r .=  '</div>';
			$r .=  linea();
			$r .=  '</div>';
			return $r;
		}
}

if(!function_exists('init_dlg_modal')){
	function init_dlg_modal($a_config){
		$mensaje = nz($a_config['mensaje']);
		$titulo = nz($a_config['titulo']);
		$class = nz($a_config['class']);
		return $a_config;
	}
}