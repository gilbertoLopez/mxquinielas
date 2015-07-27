<?php
include_once "Quiniela.class.php";
include "../seguridad/configdb.php";
include "../seguridad/sesiones.php";


$quin = new Quiniela($Host,$User,$Pass,$dbName);
		//llamamosla funcion para consultar si el usuario ya lleno quiniela
		$rs = $quin->consultaUsuariYaLleno($id,$jor);
		$row=array();
		$row=mysql_fetch_array($rs);
		$numreg=mysql_num_rows($rs);
		if($numreg>0){ ?>
			<center>
				<p> <?php echo $nombre . " " . $apellidos;?> Ya llenaste tu Quiniela de la Jornada <? echo $jor; ?></p></center>
		<? }
		else{
			echo "si jala el objeto";
		
		}




/*
include "Conexion.class.php";
$c = new Conexion("localhost","root","root","quinielas");



    $c->DBMS();
    //Establecer la base de datos
    $c->setBase();
    $sql="select * from usuario";
    //ejecutamos la sentencia
    $rs=$c->ejecutaQuery($sql);
    //insertar los registros
    $row=array();
    while($row=mysql_fetch_array($rs)){
		echo $row[1] , $row[2] ."<br/>";
	}


$sql="select * from usuario";
$rs=$c->solDatos($sql);
$row=array();
    while($row=mysql_fetch_array($rs)){
		echo $row[1] , $row[2] ."<br/>";
	}


include "clases/Usuario.class.php";
include "configdb.php";

	//cachamos datos
	$usuario=trim($_POST['usuario']);
	$contrasena=trim($_POST['contrasena']);
	
	$ref = new Usuario($Host,$User,$Pass,$dbName);
	/*$rs = $us->consultaUsuario($usuario, $contrasena);
	$ref->DBMS();
	$ref->setBase();
	$sql="select us.idusu 'Id',us.nombre_usu 'Nombre',us.apellidopa_usu 'Ap',us.apellidoma_usu 'Am',
					us.correo_usu 'Correo',us.tel_usu 'Telefono',us.estado_usu 'Estado',cu.nom_user 'Usuario',
					cu.rol_usu 'Rol'
					from cuentausuario cu,usuario us
					where nom_user = '$usuario'
					and contrasena = '$contrasena'
					and cu.idusu=us.idusu;";
	
	$rs=$ref->ejecutaQuery($sql);
		
	$row=array();
    $row=mysql_fetch_array($rs);
    $numreg=mysql_num_rows($rs);
	
	if($numreg>0){
		echo "si esta";
	}else{
		echo "no esta";
	}

*/
?>