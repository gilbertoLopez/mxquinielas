<?php

function armaEditar($nuevos,$viejos){
	$sql = array();
	
	$sql[0] = "update cuentausuario set rol_usu ='" . $nuevos['rol'] . "'";
	$sql[1] = "update usuario set estado_usu ='". $nuevos['estado']."'";
	
	if($nuevos['nombre'] != $viejos['Nombre']){
		$sql[1] .= ",nombre_usu ='" . $nuevos['nombre'] ."'";
	}
	if($nuevos['ap'] != $viejos['Ap']){
		$sql[1] .= ",apellidopa_usu ='". $nuevos['ap']. "'";
	}
	if($nuevos['am'] != $viejos['Am']){
		$sql[1] .= " ,apellidoma_usu ='" . $nuevos['am']. "'";
	}
	if($nuevos['correo'] != $viejos['Correo']){
		$sql[1] .= ",correo_usu ='" . $nuevos['correo']."'";
	}
	$nuevanac =  date('Y-m-d',strtotime($nuevos['fnac']));
	if($nuevanac != $viejos['Nacimiento']){
		$sql[1] .= ",nacimiento ='" . $nuevanac."'";
	}
	if($nuevos['telefono'] != $viejos['Telefono']){
		$sql[1] .= ",tel_usu ='". $nuevos['telefono']."'";
	}
	if($nuevos['imgpcve'] != 0){
		$sql[1] .= ", img_perfil = ".$nuevos['imgpcve'];
	}
	$sql[1] .= " where idusu =" . $nuevos['cveusuarioo'];
	
	
	if($nuevos['usuario2'] != $viejos['Usuario']){
		$sql[0] .= ",nom_user ='" . $nuevos['usuario2']."', contrasena ='" . md5($nuevos['clave'])."'";
	}
	
	$sql[0] .= " where idusu =" . $nuevos['cveusuarioo'];
	//echo "sql = ".$sql[0];
	//echo "<br/>sql = ".$sql[1];
	return $sql;
}


?>