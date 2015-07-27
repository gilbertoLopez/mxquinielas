<?php
session_start();
require_once '../config/configdb.php';
require_once '../clases/Conexion.class.php';
extract($_POST);
$typeQuery  = $_GET['type'];
$resultado  = false;
switch ($typeQuery) {
	case 'user':
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$SQL = 'SELECT COUNT(*) total FROM cuentausuario WHERE nom_user = "%s" AND idusu != %d;';
		$SQL = sprintf($SQL,$usuario,$_SESSION['IDUSU']);
		list($total) = $con->query($SQL,'arregloUnicoNum');
		$resultado = $total == 0 ? true : false;
	break;
	case 'validpass':
		$resultado = md5($clave) == $_SESSION['PASSW'] ? true : false;
	break;
	default: break;
}
echo json_encode($resultado);
?>