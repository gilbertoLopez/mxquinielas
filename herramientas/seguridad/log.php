<?php
/*
logeo
Rafael Romero
30/01/2014
*/
session_start();
include "../clases/Usuario.class.php";
include "configdb.php";

//se valida que dio click en el boton aceptar
if(isset($_POST['aceptar'])){
	//cachamos datos
	$usuario=trim($_POST['usuario']);
	$contrasena=md5(trim($_POST['contrasena']));
	
	//creamos objetode la clase usuario
	$us = new Usuario($Host,$User,$Pass,$dbName);
	//llamamosla funcion para consultar si existe el usuario y contrase�a
	$rs = $us->consultaUsuario($usuario, $contrasena);
	$row=array();
        $row=mysql_fetch_array($rs);
        $numreg=mysql_num_rows($rs);
	
	//validamos que exista el usuario
	if($numreg>0){
		//creamos variables de sesion con los registros
		$_SESSION['id']=$row[0];
		$_SESSION['nombre']=$row[1];
		$_SESSION['apepa']=$row[2];
		$_SESSION['apema']=$row[3];
		$_SESSION['correo']=$row[4];
		$_SESSION['telefono']=$row[5];
		$_SESSION['estado']=$row[6];
		$_SESSION['usuario']=$row[7];
		$_SESSION['rol']=$row[8];
		
		
		if($row[6]=='Inactivo'){ // Validamos si es usuario esta activo o inactivo
			//Si esta inactivo, aparece el error 2, que indica que no puede ingresar hasta ser autorizado
            // y se destruye la sesion
            session_destroy();
			header ("location:../../index.php?error=2");
		} else {
			//validamos si es usuario o administrador
			if(strcmp($row[8],"admin")==0){
				//redirecionamos a la pagina de administrador
				header ("location:../administrador/index.php");
			}else{
                 //redirecionamos a la pagina de usuarios
                 header ("location:../usuario/index.php");
            }
		}
	}else{
		header ("location:../../index.php?error=1");
	}
    
  }#fin_if_$aceptar
	
	

?>