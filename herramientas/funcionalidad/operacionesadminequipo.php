<?php
ini_set('display_errors','1');

$operacion = $_POST['operacion'];

include "../clases/query.php";
include "../seguridad/configdb.php";
if($operacion == 1){//agregar equipo

		
	echo json_encode($res);
	
}else if($operacion == 2){
	//validar equipo
	$nom = $_POST['equipo'];
	$respuesta = array();
	if($nom != ''){
		if(!valEquipo($nom,$Host,$User,$Pass,$dbName)){
			$respuesta['edo'] = 2;
			$respuesta['mensaje'] = "El equipo ".$nom." ya existe, ingrese otro nombre";
			$respuesta['clase'] = "notaMal";
			//echo "<p style='color:#ee2d23;font-size:1em;'>El equipo que ingreso ya existe</p>";
			//echo "<script>$('#agregarequipo').attr('disabled',true).addClass('desactivado');</script>";
		}else{
			$respuesta['edo'] = 1;
			$respuesta['mensaje'] = "El nombre del equipo es correcto";
			$respuesta['clase'] = "notaBien";
			//echo "<script>$('#agregarequipo').attr('disabled',false).removeClass('desactivado');</script>";
		}
	}else{
		//echo "<script>$('#agregarequipo').attr('disabled',false).removeClass('desactivado');</script>";
		$respuesta['edo'] = 3;
	}
	echo json_encode($respuesta);
	
}else if($operacion == 3){
	

}else if($operacion == 4){

	//editar usuario
	
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
	

}



?>