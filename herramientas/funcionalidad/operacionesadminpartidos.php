<?php
ini_set('display_errors','1');
extract($_POST);
//$operacion = $_POST['operacion'];

include "../clases/query.php";
include "../seguridad/configdb.php";

if($operacion == 1){
    //$jornada = $_POST['jornada'];
    $par = datosPartidosJor($jornada,$Host,$User,$Pass,$dbName);
    //print_r($par);
    if(count($par)>0){
        echo "  
            <center><img src='../../includes/img/iconos/cargando.gif' id='carga2' style='width:60px;display:none;'/>	
                <form id='feditarp' enctype='multipart/form-data' method='POST' action='../../herramientas/funcionalidad/operacionesadminusuario.php'>
                <table class='tb_100 oculta'>
                    <tr>
                       <td colspan='7' ><div id='nota' style='display:none'></div></td>
                   </tr>
                   <tr class='cabecera' style='font-size:.8em;'>
                       <td>Local</td>
                       <td>Visitante</td>
                       <td>Fecha</td>
                       <td>Hora</td>
                       <td>Jornada</td>
                       <td colspan='2'>Operaci&oacute;n</td>
                       
                   </tr>
                 ";
                   for($i=0;$i<count($par);$i++){
                        echo "<tr id='conMen".$par[$i]['cve_partido']."' style='background:rgba(255,255,255,0.4);display:none;'>
                            <td colspan='7'>
                                <p id='men".$par[$i]['cve_partido']."' ></p>
                            </td>
                        </tr>
                        <tr style='background:rgba(255,255,255,0.4)'>
                            <td>
                                <input type='hidden' class='cveParG' id='idpar' name='".$par[$i]['cve_partido']."' value='".$par[$i]['cve_partido']."'/>
                                <select id='loc".$par[$i]['cve_partido']."' class='listas equiG' name='loc".$par[$i]['cve_partido']."'></select>
                            </td>
                            <td>
                                <select id='vis".$par[$i]['cve_partido']."' class='listas equiG' name='vis".$par[$i]['cve_partido']."'></select>
                            </td>
                            <td>
                                <input type='text' name='fecha".$par[$i]['cve_partido']."' class='fecha ' id='fecha".$par[$i]['cve_partido']."' value='".date('d-m-Y',strtotime($par[$i]['fecha']))."'/>
                            </td>
                            <td>
                                <input type='text' name='hora".$par[$i]['cve_partido']."' class='' id='hora".$par[$i]['cve_partido']."' value='".$par[$i]['hora']."'/>
                            </td>
                             <td>
                                <input type='hidden' id='jorv".$par[$i]['cve_partido']."' name='jorv".$par[$i]['cve_partido']."' value='".$par[$i]['Jornada_cve_jornada']."'/>
                                <select id='jor".$par[$i]['cve_partido']."' name='jor".$par[$i]['cve_partido']."' class='listas jorG'></select>
                            </td>
                            <td>
                                <input type='button' class='boton editarP' id='edit".$par[$i]['cve_partido']."' name='edit".$par[$i]['cve_partido']."' for='".$par[$i]['cve_partido']."' value='Editar'/>
                            </td>
                            <td>
                                <input type='button' class='boton eliminarP' id='del".$par[$i]['cve_partido']."' name='del".$par[$i]['cve_partido']."' for='".$par[$i]['cve_partido']."' value='Borrar'/>
                            </td>
                        </tr>";
                   }
                   echo "<tr style='background:rgba(255,255,255,0.4)'>
                            <td colspan='5'></td>
                            <td colspan='2'>
                                <input type='button' class='boton' id='editarPG' name='editarPG' value='Editar Todos'/>
                            </td>
                        </tr>
                   </table>
                        <script>
                            EvePartidos(); 
                        </script>";
                   for($i=0;$i<count($par);$i++){
                        echo "<script>
                            $('#loc".$par[$i]['cve_partido']."').val(".$par[$i]['eq_local'].");
                            $('#vis".$par[$i]['cve_partido']."').val(".$par[$i]['eq_visitante'].");
                            $('#jor".$par[$i]['cve_partido']."').val(".$par[$i]['Jornada_cve_jornada'].");
                            $('.listas').trigger('chosen:updated');
                            </script>";
                   }
    }else{
        echo "NO HAY PARTIDOS PARA ESTA JORNADA";
    }
    
    
}else if($operacion == 2){
    //Modifica Partido
    if(modPartido($Host,$User,$Pass,$dbName,$cveP,$local,$visitante,$fecha,$hora,$jor)){
        $respuesta = array('mensaje' => 'El partido se actualizo con &Eacute;xito', 'clase' =>'notaBien','estado' => 1);
    }else{
        $respuesta = array('mensaje' => 'No fue Posible actualizar el partido', 'clase' =>'notaMal','estado' => 0);
    }
    
    echo json_encode($respuesta);
}else if($operacion == 3){
    //Elimina partido
    //panel eliminar
	echo "<div id='realdelp' class='resultadospost oculta'><h4>Esta seguro que Desea Eliminar el partido <strong&nbsp;&nbsp;&nbsp;</h4>
		<input type='button' name='delete' id='delete' value='Si' class='boton' onclick='deleteUser(".$cveP.");'/>
		<input type='button' name='cancelar2' id='cancelar2' value='No' class='boton' onclick='ocultameDel(\'realdelp\');' />
	</div>
	<script>$('.boton').button();</script>
	";
}else if($operacion == 4){
    
    //print_r($_POST);
    $gl = ($gl != '')? $gl: "null";
    $gv = ($gv != '')? $gv : "null";
    //echo $gl."--".$gv;
    if(agregaPartido($Host,$User,$Pass,$dbName,$locn,$visn,$gl,$gv,$fechan,$horan,$jorn,$resn)){
        $respuesta = array('mensaje' => 'El partido se agrego con &Eacute;xito', 'clase' =>'notaBien','estado' => 1);
       
    }else{
        $respuesta = array('mensaje' => 'El partido pudo ser agregado', 'clase' =>'notaMal','estado' => 0);
       
    }
    echo json_encode($respuesta);
}



?>