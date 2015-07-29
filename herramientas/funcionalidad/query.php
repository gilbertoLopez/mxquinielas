<?php
/*
 *
 */
function tablaGeneral(){
    $sql    = 'select * from equipo where liga_participa = 1 order by tot_puntos desc,diferencia_gol desc,gol_fa desc;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query($sql,'arregloAsociado');
	return $datos;
}
function validaQuinielaLLena($jornada,$idusu){
	$sql    = 'SELECT 1 FROM quiniela WHERE Usuario_idusu = %d AND Jornada_cve_jornada = %d limit 1;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$idusu,$jornada),'arregloUnicoAsoc');
	return $datos;
}
function validaPeriodo($jornada){
	$sql    = 'SELECT 1 FROM partido p WHERE p.Jornada_cve_jornada = %d AND NOW() < DATE_FORMAT(CONCAT(p.fecha," ",p.hora),"%%Y-%%m-%%d %%H:%%i:%%s") ORDER BY p.fecha,p.hora ASC limit 1;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$jornada),'arregloUnicoAsoc');
	return $datos;
}
function quinielasUsu($jornada){
	$sql    = 'SELECT u.idusu usu,u.nombre_usu,p.cve_partido part, case when comodin is null then resultado_quiniela else concat(resultado_quiniela," - ",comodin) end resul,q.resultado_real FROM quiniela q INNER JOIN partido p ON q.Partido_cve_partido = p.cve_partido INNER JOIN usuario u ON q.Usuario_idusu = u.idusu WHERE q.Jornada_cve_jornada = %d ORDER BY  q.Usuario_idusu,p.fecha,p.hora,p.cve_partido;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$jornada),'arregloAsociado');
	$format = array();
	foreach ($datos as $value) {
		if(empty($format[$value['usu']])){
			$format[$value['usu']] = array('nombre' => $value['nombre_usu']);
		}
		$format[$value['usu']][$value['part']] = array('resultado' => $value['resul'], 'real' => $value['resultado_real'] );
	}
	return $format;
}
function jornada(){
	$sql    = 'SELECT cve_jornada,dsjornada  FROM jornada WHERE DATE_FORMAT(fecha_inicio,"%u") <= DATE_FORMAT(NOW(),"%u") AND YEAR(fecha_inicio) = YEAR(NOW());';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query($sql,'arregloNumerico');
	return $datos;
}
function partidos($jornada){
	$sql    = 'SELECT p.cve_partido,p.fecha,p.hora,p.stpartido,p.motivo_cancel,p.resultado_partido resultado,eL.nom_equipo elocal, eV.nom_equipo evisit,p.gollocal,p.golvisitante,stpartido estatus,motivo_cancel motivo FROM partido p INNER JOIN equipo eL on eL.cve_equipo = p.eq_local INNER JOIN equipo eV on eV.cve_equipo = p.eq_visitante WHERE Jornada_cve_jornada = %d ORDER BY p.fecha,p.hora;'; 
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$jornada),'arregloAsociado');
	return $datos;
}
function quiniela($jornada){
	$sql    = 'SELECT p.cve_partido id,p.stpartido,p.motivo_cancel,j.dsjornada jorn,j.cve_jornada idjorn,p.fecha,p.hora,eL.nom_equipo elocal,eV.nom_equipo evisit,p.gollocal,p.golvisitante golvisit,p.resultado_partido resul FROM partido p INNER JOIN equipo eL ON p.eq_local = eL.cve_equipo INNER JOIN equipo eV ON p.eq_visitante = eV.cve_equipo INNER JOIN jornada j ON p.Jornada_cve_jornada = j.cve_jornada WHERE Jornada_cve_jornada = %d ORDER BY p.fecha,p.hora,p.cve_partido;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$jornada),'arregloAsociado');
	return $datos;
}
function verPartidos($jornada){
	$sql    = 'SELECT p.cve_partido idpart,el.cve_equipo idel,el.nom_equipo elocal, p.gollocal, p.resultado_partido,p.golvisitante,ev.cve_equipo idev,ev.nom_equipo evisit,p.stpartido,p.motivo_cancel FROM partido p INNER JOIN equipo el ON el.cve_equipo = p.eq_local INNER JOIN equipo ev ON ev.cve_equipo = p.eq_visitante WHERE p.Jornada_cve_jornada = %d;';
	$con    = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos  = $con->query(sprintf($sql,$jornada),'arregloAsociado');
	return $datos;
}
function actualizarPart($golL,$golV,$resul,$idPart){
	$sql = 'UPDATE partido SET gollocal=%d,golvisitante=%d,resultado_partido="%s",stpartido=1,motivo_cancel=null WHERE cve_partido=%d;';
	$con = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$afe = $con->query(sprintf($sql,$golL,$golV,$resul,$idPart),'afecto?');
	return $afe;
}
function cancelarPart($motivo,$idPart){
	$sql = 'UPDATE partido SET gollocal=null,golvisitante=null,resultado_partido=null,stpartido=0,motivo_cancel="%s" WHERE cve_partido=%d;';
	$con = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$afe = $con->query(sprintf($sql,$motivo,$idPart),'afecto?');
	return $afe;
}
 
function actResultadoQuin($idPart){
	$sql = 'UPDATE quiniela q INNER JOIN partido p ON q.Partido_cve_partido = p.cve_partido SET q.resultado_real = case when q.resultado_quiniela = p.resultado_partido then 1 when q.comodin = p.resultado_partido then 1 else 0 end WHERE p.cve_partido = %d;';
	$con = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$afe = $con->query(sprintf($sql,$idPart),'afecto?');
	return $afe;
}
function getDatosUsuario(){
	$sql   = 'SELECT u.*,cu.nom_user FROM usuario u INNER JOIN cuentausuario cu ON u.idusu = cu.idusu WHERE u.idusu = %d;';
	$con   = new Conexion($GLOBALS['Host'],$GLOBALS['User'],$GLOBALS['Pass'],$GLOBALS['dbName']);
	$datos = $con->query(sprintf($sql,$_SESSION['IDUSU']),'arregloUnicoAsoc');
	return $datos;
}
?>
