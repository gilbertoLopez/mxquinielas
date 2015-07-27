<?php
ini_set('display_errors','1');
include "../clases/Conexion.class.php";
include "../seguridad/configdb.php";
//session_start();
//if(empty($_SESSION['auten'])){exit();}
$sql = array();

$sql['usuarios'] = "SELECT us.idusu 'Id', CONCAT(us.nombre_usu, ' ', us.apellidopa_usu, ' ', us.apellidoma_usu) 'Nombre' FROM cuentausuario cu, usuario us where cu.idusu = us.idusu";
$sql['jornadas'] = "select cve_jornada, dsjornada from jornada;";
$sql['equipos'] = "select cve_equipo,nom_equipo from equipo";


$objUsu = new Conexion($Host, $User, $Pass, $dbName);

$consulta = (int) $_GET['consulta'];
$select = '';

switch($consulta){
    case 1 : $select = $sql['usuarios'];    break;
    case 2 : $select = $sql['jornadas'];    break;
    case 3 : $select = $sql['equipos'];    break;
    default: $select = null;
}

if(!empty($select)){
    echo utf8_encode(json_encode($objUsu ->query($select,'arregloNumerico')));
}
?>