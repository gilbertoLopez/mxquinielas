<?php
include_once 'herramientas/config/msjErrores.php';
include_once 'herramientas/clases/Conexion.class.php';
include_once 'herramientas/config/configdb.php';

if(!$_SESSION['AUTEN']){
	$_SESSION['ERROR'] = ERROR_ACCESO;
	header('Location:index.php');
}

$titulo   = 'MX Quinielas';
$css      = array('estilos_usu.css','jquery-ui_admin/jquery-ui.css','icono.min.css');
$js       = array('jquery-1.11.1.min.js');
$jsPie    = array('usuarios.js');
$imgFONDO = 'azteca.jpg';
$menu     = array(
				  'Inicio'=>'?p=principal&m=usuario&v=ini',
				  'Quinielas'=>'?p=principal&m=usuario&v=quin',
				  // 'Torneo'=>'?p=principal&m=usuario&v=torn',
				  'Mi Perfil'=>'?p=principal&m=usuario&v=edit',
				  'Salir'=>'herramientas/seguridad/salir.php'
				 );
$cont = '';
$activo = array('href'=>'#','class'=>'liActivo');

switch($vista)
{
	case 'ini':
		$cont     = 'vistas/usuario/contenido/inicio.php';
		$menu['Inicio'] = $activo;
		$imgFONDO = 'fondo13.jpg';
		break;
	case 'quin':
		$cont     = 'vistas/usuario/contenido/quinielas.php';
		array_push($js,'general.js');
		$menu['Quinielas'] = $activo;
		$imgFONDO = 'fondo14.jpg';
		break;
	case 'torn':
		$cont     = 'vistas/usuario/contenido/torneo.php';
		array_push($js,'general.js');
		$menu['Torneo'] = $activo;
		$imgFONDO = 'fondo15.jpg';
		break;
	case 'edit':
		$cont     = 'vistas/usuario/contenido/perfil.php';
		$menu['Mi Perfil'] = $activo;
		array_push($js,'general.js');
		array_push($js,'jquery.validate.min.js');
		array_push($js,'edit.js');
		$imgFONDO = 'fondo15.jpg';
		break;
	default:
		$cont     = 'vistas/usuario/contenido/error.php';
		break;
}

include_once 'vistas/template.php';
?>