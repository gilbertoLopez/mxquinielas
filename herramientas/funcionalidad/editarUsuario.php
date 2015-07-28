<?php
session_start();
require_once '../config/configdb.php';
require_once '../clases/Conexion.class.php';
extract($_POST);
$id_usuario = $_SESSION['IDUSU'];
$resultado  = array('status'=>'OK','mns'=>'Información actualizada!');
$sqlUsu     = 'UPDATE usuario SET nombre_usu="%s", apellidopa_usu="%s", apellidoma_usu="%s", tel_usu="%s",nacimiento="%s",correo_usu="%s" WHERE idusu = %d;';
$sqlCUsu    = 'UPDATE cuentausuario  SET nom_user="%s", contrasena=md5("%s") WHERE idusu = %d;';
$con        = new Conexion($Host,$User,$Pass,$dbName);
$sql        = sprintf($sqlUsu,$nombre,$apellidopa,$apellidoma,$telefono,date('Y-m-d',strtotime($fechaNac)),$email,$_SESSION['IDUSU']);
$result1    = $con->query($sql,'afecto?');
if(!empty($changeUser)){
	$sql     = sprintf($sqlCUsu,$usuario,$clave1,$_SESSION['IDUSU']);
	$result2 = $con->query($sql,'afecto?');
	if($result2){
		$_SESSION['PASSW'] = md5($clave1);
	}
}
if(empty($result1) && empty($result2))
{
    $resultado['status'] = 'ERROR';
    $resultado['mns'] = 'No se detectarón cambios al actualizar.';
}
echo json_encode($resultado);
?> 