<?php
require_once '../config/configdb.php';
require_once '../clases/Conexion.class.php';
require_once 'query.php';
extract($_POST);
if(empty($cancelar)){
    actualizarPart($gol_local,$gol_visit,$resultado,$idpart);
}
else{
    cancelarPart($motivoC,$idpart);
}
actResultadoQuin($idpart);

$respuesta = array('estatus'=>'OK','accion'=>'x','contenido'=>$_POST);
echo json_encode($respuesta);
?>