<?php
session_start();
$pagina  = (!empty($_GET['p']))? $_GET['p'] : 'inicio';
$modulo  = (!empty($_GET['m']))? $_GET['m'] : 'usuario';
$vista   = (!empty($_GET['v']))? $_GET['v'] : 'logueo';
$pagina  = ucfirst($pagina).'.php';
$modulo .= '/';
$ruta    = 'vistas/'.$modulo.$pagina;
if(!file_exists($ruta))
{
    $vista   = 'error';
    $ruta    = 'vistas/usuario/Inicio.php';
}
include_once $ruta;
?>

