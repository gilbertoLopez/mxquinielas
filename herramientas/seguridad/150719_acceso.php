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
	
	$sql        = 'SELECT rol_usu,idusu FROM cuentausuario WHERE convert(nom_user using binary) = convert(\'%s\' using binary) and contrasena = md5(\'%s\');';
	$usuario    = addslashes($usuario);
	$contrasena = addslashes($contrasena);
	$sql        = sprintf($sql,$usuario,$contrasena);
	$datos      = $c->query($sql,'arregloUnicoNum');
	
	if(count($datos) > 0)
	{
		list($tipo,$idUsu)  = $datos;
		$_SESSION['TIPO']   = $tipo;
		$_SESSION['IDUSU']  = $idUsu;
		$_SESSION['AUTEN']  = TRUE;
		$URL                = '../../index.php?p=principal&m=usuario&v=ini';
		unset($_SESSION['ERROR']);
	}
	else
	{
		$_SESSION['ERROR'] = ERROR_INFORMACION;
	}
}
header('Location:'.$URL);
?>