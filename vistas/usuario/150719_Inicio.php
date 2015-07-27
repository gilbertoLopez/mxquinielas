<?php
$titulo   = 'MX Quinielas';
$css      = array('estilos_usu.css','jquery-ui_admin/jquery-ui.css','icono.min.css');
$jsPie    = array('usuarios.js');


switch($vista)
{
	case 'error':
		$cont  = 'vistas/usuario/contenido/error.php';
		$js    = array('jquery-1.11.1.min.js');
		$menu  = array('Inicio'=>'index.php');
		$imgFONDO = 'azteca.jpg';
	break;
	case 'instr':
		$cont = 'vistas/general/Instrucciones.php';
		$js   = array('jquery-1.11.1.min.js','slider/jssor.js','slider/jssor.slider.js','slider/jssor.config.js');
		$menu = array('Acceder'=>'#accesoUSU','Instrucciones' => '?p=instrucciones&m=general&v=instr');
		$imgFONDO = 'azteca.jpg';
	break;
	default:
		$cont = 'vistas/usuario/contenido/logueo.php';
		$js   = array('jquery-1.11.1.min.js','slider/jssor.js','slider/jssor.slider.js','slider/jssor.config.js');
		$menu = array('Acceder'=>'#accesoUSU','Instrucciones' => '?p=instrucciones&m=general&v=instr');
		array_push($css,'jssor.slider.css');
		$imgFONDO = 'azteca.jpg';
		break;
}

include_once 'vistas/template.php';
?>