<?php
/*Documento Generado para Consultas sin necesidad de generar clase
Rafael Romero 1/05/14
Ultima Edicion: 27/02/15 por: Rafael
*/
include "Conexion.class.php";

/*<<<<<CONSULTAS DE EQUIPOS>>>>>*/
function valEquipo($nom,$Host,$User,$Pass,$dbName){
		$sql= "SELECT * FROM equipo;";
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$datos = $con->query($sql,'arregloAsociado');
		$con->cerrarConexion();
		$res = true;
		for($i = 0;$i < count($datos); $i++){
		    if(trim(strtolower($nom)) === trim(strtolower($datos[$i]['nom_equipo']))){
		       $res = false;
		    }	
		}
		return $res;
}
  
//funcion para darle estilo a la tabla
function colortr($i){
	$color = "";
	if($i%2==0){ $color = "#9e9da3";}
	else{ $color = "#d5d5d7"; }
	return $color;
}

function fechaFor($fecha){
	$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$diaActual = substr($fecha,8,2); //extraemos el dia 
	$mesActual = substr($fecha,5,2); //extraemos el mes 
	$anioActual = substr($fecha,0,4); //extraemos el a?o 
	return $diaActual." de ".$meses[$mesActual-1]." del ".$anioActual;
}

//*
function optimizarImagen($archivo,$tam)
{
    $mimes     = array('png' => 'png','jpe' => 'jpeg','jpeg' => 'jpeg','jpg' => 'jpeg','gif' => 'gif');
    $extension = @strtolower(end(explode('.',$archivo)));
    if(!empty($mimes[$extension]))
    {
        $tipo         = $mimes[$extension];
        $crear        = 'imagecreatefrom'.$tipo;
        $image        = 'image'.$tipo;
        $imgOriginal  = $crear( $archivo );
        $anchoOrigen  = imagesx( $imgOriginal );
        $altoOrigen   = imagesy( $imgOriginal );
        $ancho_limite = $tam;
        if($anchoOrigen > $altoOrigen)
        {// para foto horizontal
                $anchoOrigen = $ancho_limite;
                $altoOrigen  = $ancho_limite*imagesy( $imgOriginal )/imagesx( $imgOriginal );
        }
        else
        {//para fotos verticales
                $altoOrigen  = $ancho_limite;
                $anchoOrigen = $ancho_limite*imagesx( $imgOriginal )/imagesy( $imgOriginal );
        }
        $imgNuevo = imagecreatetruecolor($anchoOrigen ,$altoOrigen );// se crea la imagen segun las dimensiones dadas
        if($tipo == 'png')
        {
            imagesavealpha($imgNuevo, true); 
            $color = imagecolorallocatealpha($imgNuevo,0x00,0x00,0x00,127 ); 
            imagefill($imgNuevo, 0, 0, $color);
        }
        imagecopyresized( $imgNuevo, $imgOriginal, 0, 0, 0, 0, $anchoOrigen, $altoOrigen, imagesx( $imgOriginal ), imagesy( $imgOriginal ) );
        $image( $imgNuevo, $archivo);//se guarda la nueva imagen
        imagedestroy( $imgOriginal );
        imagedestroy( $imgNuevo );
    }
}

//*
function cargaArchivo($archivo,$ruta,$tmp){
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if(!is_dir($ruta)) 
            mkdir($ruta, 0777);
        //comprobamos si el archivo ha subido
        if ($archivo && move_uploaded_file($tmp,$ruta.$archivo))
        {
           optimizarImagen($ruta.$archivo,200);
		   return true;
        }else{
			return false;	
		}
}

//*
function InserImg($nombre,$tipo,$descripcion,$Host,$User,$Pass,$dbName){
		$sql = "insert into cat_imagenes values(null,'".$nombre."',".$tipo.",'".$descripcion."','".date('Y-m-d')."');";
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$idimg = $con->query($sql,'id');
		return $idimg;
}

//*
function updateImg($idimgact,$imgnva,$tipo,$descripcion,$Host,$User,$Pass,$dbName){
		$idnueva = InserImg($imgnva,$tipo,$descripcion,$Host,$User,$Pass,$dbName);
		if($idimgact != 1){
				eliminaArch($idimgact,$Host,$User,$Pass,$dbName);
		}
		return $idnueva;
}

//*
function eliminaArch($idimgact,$Host,$User,$Pass,$dbName){
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$sql = "delete from cat_imagenes where cve_imagen = ".$idimgact;
		$con->query($sql,'');
		$con->cerrarConexion();
}


// FUNCIONES PARTIDOS -------------------------------------------------------------------------------

//* 
function datosPartidosJor($jor,$Host,$User,$Pass,$dbName){
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$sql = "select par.cve_partido, par.fecha, par.hora, par.eq_local,loc.nom_equipo, par.eq_visitante, vis.nom_equipo,par.Jornada_cve_jornada,jor.dsjornada from partido par inner join equipo loc on par.eq_local = loc.cve_equipo inner join equipo vis on par.eq_visitante = vis.cve_equipo	inner join jornada jor on par.Jornada_cve_jornada = jor.cve_jornada where par.Jornada_cve_jornada = ".$jor." order by par.fecha;";
		$datos = $con->query($sql,'arregloAsociado');
		$con->cerrarConexion();
		return $datos;
}

function agregaPartido($Host,$User,$Pass,$dbName,$locn,$visn,$gl,$gv,$fechan,$horan,$jorn,$resn){
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$sqlE = "INSERT INTO partido (cve_partido, fecha, hora, gollocal, golvisitante, resultado_partido, eq_local, eq_visitante, Jornada_cve_jornada, stpartido, motivo_cancel) VALUES (null, '".date('Y-m-d',strtotime($fechan))."', '".$horan."', ".$gl.", ".$gv.", '".$resn."', ".$locn.", ".$visn.", ".$jorn.", 0, '');";
		$retorna = $con->query($sqlE,'afecto?');
		$con->cerrarConexion();
		return $retorna;
}

function modPartido($Host,$User,$Pass,$dbName,$cveP,$local,$visitante,$fecha,$hora,$jor){
		$con = new Conexion($Host,$User,$Pass,$dbName);
		$sqlE = "UPDATE partido SET fecha = '".date('Y-m-d',strtotime($fecha))."', hora = '".$hora."', gollocal = null, golvisitante = null, resultado_partido = '', eq_local = ".$local.", eq_visitante = ".$visitante.", Jornada_cve_jornada = ".$jor.", stpartido = 0, motivo_cancel = '' WHERE cve_partido = ".$cveP;
		$retorna = $con->query($sqlE,'afecto?');
		$con->cerrarConexion();
		return $retorna;
} 



?>