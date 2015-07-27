<?php
//session_start();
include "sesiones.php";
if($rol != 'user'){
	header ("location:../../index.php?error=1");
}
?>