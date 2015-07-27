<?php
ini_set('display_errors','1');

$operacion = $_POST['operacion'];

include "../clases/Usuario.class.php";
include "../clases/query.php";

include "../seguridad/configdb.php";
if($operacion == 1){//agregar usuario
	
	foreach($_POST as $clave => $valor){
		$fdatos[$clave] = $valor;
	}
	$nombre_foto = 'defecto.png';
	$fileperfil = 1;
	if($_FILES['perfil']['error'] == 0){
		$nombre_foto = $_FILES['perfil']['name'];
		cargaArchivo($_FILES['perfil']['name'],"../../includes/img/perfil/",$_FILES['perfil']['tmp_name']);
		$idimg = InserImg($_FILES['perfil']['name'],1,'Foto Perfil',$Host,$User,$Pass,$dbName);
		if($idimg != '' && $idimg != null){
			$fileperfil = $idimg;
		}
	}
	
	$tel = (!empty($fdatos['telefono']))? $fdatos['telefono']:'';
	$mail = (!empty($fdatos['correo']))? $fdatos['correo']:'';
	$fnac = (!empty($fdatos['fnac']))? date('Y-m-d',strtotime($fdatos['fnac'])):'';
    $datosUsu = array();
    $datosUsu[0]=ucwords(strtolower(trim($fdatos['nombre'])));
    $datosUsu[1]=ucwords(strtolower(trim($fdatos['ap'])));
    $datosUsu[2]=ucwords(strtolower(trim($fdatos['am'])));
    $datosUsu[3]=$mail;
    $datosUsu[4]= $tel;
    $datosUsu[5]=trim($fdatos['usuario']);
    $datosUsu[6]=md5(trim($fdatos['clave']));
    $datosUsu[7]=trim($fdatos['estado']);
	$datosUsu[8]=trim($fdatos['rol']);
	$datosUsu[9]=$fnac;
	$datosUsu[10]= $fileperfil;

    $objUsu = new Usuario($Host, $User, $Pass, $dbName);
    $rs = $objUsu->guardarUsuario($datosUsu);
    if($rs){
        $res = array('tel'=>$datosUsu[4],'correo' => $datosUsu[3],'clase'=>'notaBien','mensaje'=>'Usuario agregado con Exito', 'estado' => 1,'nombre' => $datosUsu[0].' '.$datosUsu[1].' '.$datosUsu[2],'usuario' => $datosUsu[5],'img'=>$nombre_foto,'rol'=>$datosUsu[8]);
    }else{
        $res = array('clase'=>'notaMal','mensaje'=>'No se agrego el Usuario con Exito', 'estado' => 2);
    }
		
	echo json_encode($res);
	
}else if($operacion == 2){
	//validar usuario
	$u = $_POST['usu'];
	if($u != ''){
		$usu= new Usuario($Host,$User,$Pass,$dbName);
		$rs = $usu->valUsuNuevo($u);
		$numreg = mysql_num_rows($rs);
	
		if($numreg>0){	
			echo "<p style='color: #ee2d23;font-size:1em;'>El usuario ingresado no esta disponible, elija otro</p>
			<script>
				$('#clave, #clave2').val('').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)');
			</script>
			";
		}else{ 
			echo "<p style='color: green;font-size:1em;'>El usuario es correcto</p>
			<script>
				$('#clave, #clave2').attr('disabled',false).css('background','#fff');
			</script>
			";
		}
		
	}else{
		echo "
		<script>
			$('#clave, #clave2').val('').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)');
		</script>
		";
	}

}else if($operacion == 3){
	//muestra datos
	$usu= new Usuario($Host,$User,$Pass,$dbName);
	$rs = $usu->verUsuarioSel($_POST['cveusu']);
	//echo $_POST['cveusu'];
	$sinimg = ($_POST['accion'] == 'Actualizar')? "" : "style='display:none'";
	while($datos = mysql_fetch_array($rs)){
		
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>	
	 <form id='feditar' enctype='multipart/form-data' method='POST' action='../../herramientas/funcionalidad/operacionesadminusuario.php'>
	 <table class='tb_100 oculta'>
		<tr>
			<td colspan='2' style='text-align:left'>
				<h1>".$_POST['accion']." Usuario</h1>
				<input type='hidden' value='".$datos['Id']."' name='cveusuarioo' id='cveusuarioo'/>
				<input type='hidden' value='".$datos['Usuario']."' name='usuariousuario' id='usuariousuario'/>
				<input type='hidden' id='operacion' name='operacion' value='4'/>
			</td>
		</tr>
		<tr>
			<td colspan='7' ><div id='nota' ></div></td>
		</tr>
		<tr>
			<td rowspan='10'><center>
				<div class='marco2'><img src='../../includes/img/perfil/".$datos['imgperfil']."' class='img".$_POST['accion']."'/></div>
				<input type='hidden' value='".$datos['imgperfil']."' name='imgperfilac ' />
			</center></td>
		<tr>
			<td><label for='nombre' >Nombre(s)</label></td>
			<td><input type='text' name='nombre' id='nombre' class='campoform requerido letra' value='".$datos['Nombre']."'/></td>
			<td><label for='ap'>A. Paterno</label></td>
			<td><input type='text' name='ap' id='ap' class='campoform requerido letra' value='".$datos['Ap']."'/></td>
			<td><label for='am'>A. Materno</label></td>
			<td><input type='text' name='am' id='am' class='campoform requerido letra' value='".$datos['Am']."'/></td>
			<td><input type='button' name='".$_POST['accion']."' value='".$_POST['accion']."' id='".$_POST['accion']."' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='telefono'>Telefono</label></td>
			<td><input type='text' name='telefono' id='telefono' class='campoform numeros' value='".$datos['Telefono']."'/></td>
			<td><label for='correo'>Correo</label></td>
			<td><input type='text' name='correo' id='correo' class='campoform correo' value='".$datos['Correo']."'/></td>
			<td><label for='fnac'>Fecha de Nacimiento</label></td>
			<td><input type='text' name='fnac' id='fnac' class='campoform fecha' value='".date('d-m-Y',strtotime($datos['Nacimiento']))."'/></td>
			<td><input type='button' name='cancelar' value='Cancelar' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='usuario2'>Usuario</label></td>
			<td><input type='text' name='usuario2' id='usuario2' class='campoform requerido latino' value='".$datos['Usuario']."'/></td>
			<td><label for='clave'>Contrase&ntilde;a</label></td>
			<td><input type='text' name='clave' id='clave' class='campoform latino' /></td>
			<td><label for='clave2'>Confirma Contrase&ntilde;a</label></td>
			<td><input type='text' name='clave2' id='clave2' class='campoform latino'/></td>
			
		</tr>
		<tr>
			<td><label for='estado'>Estado</label></td>
			<td><select name='estado' id='estado' class='campoform listas requerido' >
					<option value='Activo'>Activo</option>
					<option value='Inactivo'>Inactivo</option>
				</select>
			</td>
			<td><label for='rol'>Rol</label></td>
			<td><select name='rol' id='rol' class='campoform listas requerido' >
				<option value='user'>Usuario</option>
				<option value='admin'>Adminiatrador</option>
				</select>
			</td>
			<td colspan='2' id='validaciones'></td>
		</tr>
		<tr>
			<td><label>Foto</label></td>
			<td colspan='3' style='text-align:left;'>
				<input type='file' name='eperfil' id='eperfil' class='boton campoform' value='".$datos['imgperfil']."'/>
			</td>
			<td colspan='2'>
				<p id='msgimg'></p>
			</td>
		</tr>
		<tr ".$sinimg.">
			<td></td>
			<td><input type='checkbox' value='1' name='sinimg' id='sinimg'/>&nbsp;<label>Eliminar Imagen</label></td>
		</tr>
	 </table>
	 </form>
	 <div id='panel'><div>
	 <script>
		$('#rol').val('".$datos['Rol']."').trigger('chosen:updated');
		$('#estado').val('".$datos['Estado']."').trigger('chosen:updated');
		if('".$_POST['accion']."' == 'Eliminar'){
		
			$('.campoform').attr('disabled',true);
			$('#usuariosdel').attr('disabled',false);
		}
	</script>
	
	 </center>";
	echo utf8_encode(" <script>
		$('.letra').on('keyup',function(){
	   var normal = $(this).val().toUpperCase();
	   normal = normal.replace(/[Á]/g, 'A');
	   normal = normal.replace(/[É]/g, 'E');
	   normal = normal.replace(/[Í]/g, 'I');
	   normal = normal.replace(/[Ó]/g, 'O');
	   normal = normal.replace(/[Ú]/g, 'U');
	   normal = normal.replace(/[\\n\\r\\t]/g, '');
	   normal = normal.replace(/[^A-Z0-9%\\-,.Ñ\\s]/g, '');
	   $(this).val(normal);
		});
	 </script>");
	echo "
	<script type='text/javascript' src='../../includes/js/indexsecundario.js' ></script>";

	}
	

}else if($operacion == 4){

	//editar usuario
	include "funciones.php";
	$cveuo = $_POST['cveusuarioo'];
	$usu= new Usuario($Host,$User,$Pass,$dbName);
	$rs = $usu->verUsuarioSel($cveuo);
	$viejos = mysql_fetch_array($rs);
	$fileperfil = 0;
	//print_r($_POST);
	
	foreach($_POST as $clave => $valor){
		$nuevos[$clave] = $valor; 
	}
	//echo "error = ".$_FILES['eperfil']['error'];exit(0);
	//no selecciono el checkbox
	if(empty($_POST['sinimg'])){
		//echo "no existe";
		if($_FILES['eperfil']['error'] == 0){//validamos si cargo nuevo archivo
			
			$nombre_foto = $_FILES['eperfil']['name'];
			if($viejos['cve_imagen'] != 1){
				unlink("../../includes/img/perfil/".$viejos['imgperfil']);
			}
			cargaArchivo($_FILES['eperfil']['name'],"../../includes/img/perfil/",$_FILES['eperfil']['tmp_name'],$viejos['imgperfil']);
			$idimg = updateImg($viejos['cve_imagen'],$_FILES['eperfil']['name'],1,'Foto Perfil',$Host,$User,$Pass,$dbName);
			
			if($idimg != '' && $idimg != null){
				$fileperfil = $idimg;
			}
		}
	//checkbox seleccionado (se eliminara la imagen)
	}else{
		//echo "si existe checkbox";
		if($viejos['imgperfil'] != $fileperfil){
			unlink("../../includes/img/perfil/".$viejos['imgperfil']);
			eliminaArch($viejos['cve_imagen'],$Host,$User,$Pass,$dbName);
		}
		$nombre_foto = 'defecto.png';
		$fileperfil = 1;
	}
	
	
	$nuevos['imgpcve'] = $fileperfil;
	$sql = armaEditar($nuevos,$viejos);
	//exit(0);
	$usu->DBMS();
    $usu->setBase();
                        
    if($usu->ejecutaQuery($sql[0])){
		if($usu->ejecutaQuery($sql[1])){
		$res = array('clase'=>'notaBien','mensaje'=>'Usuario actualizado con Exito', 'estado' => 1,'usuariio' =>$cveuo);
		}else{
			$res = array('clase'=>'notaMal','mensaje'=>'No se actualizo el Usuario con Exito, intente mas tarde 1 ', 'estado' => 2);
		}
	}else{
		$usu->cerrarConexion();
		$res = array('clase'=>'notaMal','mensaje'=>'No se actualizo el Usuario con Exito, intente mas tarde 2', 'estado' => 2);
	}

	echo json_encode($res);
	
}else if($operacion == 5){
	//panel eliminar
	echo "<div id='realdel' class='resultadospost oculta'><h4>Esta seguro que Desea Eliminar al usuario \"".$_POST['u']."\"<strong&nbsp;&nbsp;&nbsp;</h4>
		<input type='button' name='delete' id='delete' value='Si' class='boton' onclick='deleteUser();'/>
		<input type='button' name='cancelar2' id='cancelar2' value='No' class='boton' onclick='cancelar2();' />
	</div>
	<script>$('.boton').button();</script>
	";
}else if($operacion == 6){
	//eliminar usuario
	$idusua = $_POST['cu'];
	$objUsu = new Usuario($Host, $User, $Pass, $dbName);
    $rs = $objUsu->eliminarUsuario($idusua);
	if($rs){
        $res = array('clase'=>'notaBien','mensaje'=>'Usuario eliminado con Exito', 'estado' => 1);
    }else{
        $res = array('clase'=>'notaMal','mensaje'=>'No se elimino el Usuario con Exito, intente mas tarde', 'estado' => 2);
    }
	echo json_encode($res);
	
}else if($operacion == 7){
	//validar usuario creado
	$u = $_POST['usu'];
	if($u != ''){
	   $creado = $_POST['creado'];
		$usu= new Usuario($Host,$User,$Pass,$dbName);
		$rs = $usu->valUsuNuevo($u);
		$numreg = mysql_num_rows($rs);
	
		if($u == $creado){ 
			echo "<p style='color: green;font-size:1.3em;'>El usuario no es diferente, si desea cambiar<br/> contrase&ntilde;a debe ingresar un nuevo usuario</p>
			<script>$('#Actualzar').attr('disabled',false);
			limpiar();
			$('#clave, #clave2').val('').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)').removeClass('requerido');
			
			</script>
			";
		}else if($numreg>0){	
			echo "<p style='color: #ee2d23;font-size:1.3em;'>El usuario ingresado no esta disponible, elija otro</p>
			<script>
				$('#clave, #clave2').val('').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)').addClass('requerido');
				$('#Actualzar').attr('disabled',true);
			</script>
			";
		}else{ 
			echo "<p style='color: green;font-size:1.3em;'>El usuario es correcto</p>
			<script>
				$('#clave, #clave2').attr('disabled',false).css('background','#fff').addClass('requerido');
				
				$('#Actualzar').attr('disabled',false);
			</script>
			";
		}
		
	}else{
		echo "
		<script>
			$('#clave, #clave2').val('').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)');
		</script>
		";
	}

}else if($operacion == 8){
	//listado de usuarios
	$usu= new Usuario($Host,$User,$Pass,$dbName);
	$rs = $usu->listaUsuarios();

	while($datos = mysql_fetch_array($rs)){
		echo "
		<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>	
		 <form id='fagregar' method='POST' >
		 <table class='tb_100' style='font-size:12px;border-radius: 15px;'>
			<tr>
				<td rowspan='10'><center>
					<div class='marco1'><img src='../../includes/img/perfil/".$datos['imgperfil']."' class='img'/></div>
				</center></td>
			<tr style='text-align:left;'>
				<td>NOMBRE(S) :</td>
				<td><label>".$datos['Nombre']."</label></td>
				<td>A. PATERNO :</td>
				<td><label>".$datos['Ap']."</label></td>
				<td>A. MATERNO :</td>
				<td><label>".$datos['Am']."</label></td>
			</tr>
			<tr style='text-align:left;'>
				<td>TELEFONO :</td>
				<td><label>".$datos['Telefono']."</label></td>
				<td>CORREO :</td>
				<td><label>".$datos['Correo']."</label></td>
				<td>F. NACIMIENTO :</td>
				<td><label>".$datos['Nacimiento']."</label></td>
			</tr>
			
			<tr style='text-align:left;'>
				<td>USUARIO :</td>
				<td><label>".$datos['Usuario']."</label></td>
				<td>ROL :</td>
				<td><label>".$datos['Rol']."</label></td>
				<td>ESTADO :</td>
				<td><label>".$datos['Estado']."</label></td>
			</tr>
	
		 </table><br/>
		 </form>
	
		 </center>";
	}
	
}



?>