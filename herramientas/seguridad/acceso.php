<?php
session_start();
include_once '../clases/Conexion.class.php';
include_once '../config/configdb.php';
include_once '../config/msjErrores.php';

$_SESSION['ERROR'] = ERROR_ACCESO;
$_SESSION['AUTEN'] = FALSE;
$URL = '../../index.php';
if(!empty($_POST))
{
	extract($_POST);
	$c = new Conexion($Host,$User,$Pass,$dbName);
	
	$sql        = 'SELECT cu.rol_usu,cu.idusu,u.nombre_usu,u.apellidopa_usu,u.apellidoma_usu,u.estado_usu,ci.nombre img FROM cuentausuario cu INNER JOIN usuario u ON u.idusu = cu.idusu INNER JOIN cat_imagenes ci ON u.img_perfil = ci.cve_imagen WHERE convert(nom_user using binary) = convert(\'%s\' using binary) and contrasena = md5(\'%s\');';
	$usuario    = addslashes($usuario);
	$contrasena = addslashes($contrasena);
	$sql        = sprintf($sql,$usuario,$contrasena);
	$datos      = $c->query($sql,'arregloUnicoNum');
	
	if(count($datos) > 0)
	{
		list($tipo,$idUsu,$nombre,$apellidoPa,$apellidoMa,$status,$img)  = $datos;
		$status = ($status == 'Activo')? true : false;
		if($status){
			$page = ($tipo == 'user')? 'usuario' : 'administrador';
			$_SESSION['TIPO']    = $tipo;
			$_SESSION['IDUSU']   = $idUsu;
			$_SESSION['NOMBRE']  = $nombre.' '.$apellidoPa.' '.$apellidoMa;
			$_SESSION['IMGPER']  = $img;
			$_SESSION['PASSW']   = md5($contrasena);
			$_SESSION['AUTEN']   = true;
			$URL                 = '../../index.php?p=principal&m='.$page.'&v=ini';
			unset($_SESSION['ERROR']);
		}else{
			$_SESSION['ERROR'] = ERROR_STATUS;
		}
	}
	else
	{
		$_SESSION['ERROR'] = ERROR_INFORMACION;
	}
}
header('Location:'.$URL);
?>