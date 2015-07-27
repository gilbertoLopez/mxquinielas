<?php
session_start();
require_once '../config/configdb.php';
require_once '../clases/Conexion.class.php';

$id_usuario = $_SESSION['IDUSU'];
$id_jornada = $_POST['idJornada'];
$id_comodin = $_POST['comodin'];
$resultado  = array('status'=>'OK','mns'=>'Registro almacenado con exito');

$quiniela = array();
$i = 0;
foreach($_POST as $nombre => $valor)
{
    if(preg_match('/^select-/',$nombre))
    {
        list(,$id_partido) = explode('-',$nombre);
        $quiniela[$i] = '(NULL,'.$id_jornada.','.$id_usuario.','.$id_partido.',"'.$valor.'",NULL,NULL)';
        $i++;
    }else if(preg_match('/^comodinCHK-/',$nombre)){
        list($comodin1,$comodin2) = $valor;
        $quiniela[$i] = '(NULL,'.$id_jornada.','.$id_usuario.','.$id_comodin.',"'.$comodin1.'","'.$comodin2.'",NULL)';
        $i++;
    }
}
$datosQuin  = implode(',',$quiniela);
$sqlQuiniel = 'INSERT INTO quiniela VALUES '.$datosQuin.';';
$con        = new Conexion($Host,$User,$Pass,$dbName);
$r1         = $con->query($sqlQuiniel,'afecto?');
if(empty($r1))
{
    $resultado['status'] = 'ERROR';
    $resultado['mns'] = 'Error al guardar, por favor intente de nuevo';
}
echo json_encode($resultado);
?>