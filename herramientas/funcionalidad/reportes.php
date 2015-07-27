<?php
ini_set("display_errors",1);
include "../clases/query.php";
include "../seguridad/configdb.php";
include "../../includes/MPDF5/mpdf.php";

$tipo = $_GET['tp'];
$jor = $_GET['jrnd'];


for($i=1;$i<=18;$i++){
	if(md5($i) == $jor){
		$jornada = $i;
		break;
	}
}


if(md5(1) === $tipo){
	$partidos = verPartidos($jornada,$Host,$User,$Pass,$dbName);
	$cont = "<table style='text-align:center;border: dashed 2px;'>
				<tr>
					<td colspan='5'><h1>Quiniela Jornada ".$jornada."</h1></td>
				</tr>
				<tr>
					<td colspan='2'><strong>Local</strong></td>
					<td><strong>Empate</strong></td>
					<td colspan='2'><strong>Visitante</strong></td>
				</tr>
			";
	for($i = 0; $i < count($partidos); $i++){
		$cont .= "<tr>
			<td><img src='../../includes/img/escudo/".$partidos[$i]['local'].".png' style='width:30px;height:30px'/></td>
			<td>".$partidos[$i]['local']."</td>
			<td>
				<img src='../../includes/img/iconos/chck.png' style='width:30px;height:30px'/>
				<img src='../../includes/img/iconos/chck.png' style='width:30px;height:30px'/>
				<img src='../../includes/img/iconos/chck.png' style='width:30px;height:30px'/>
			</td>
			<td>".$partidos[$i]['visitante']."</td>
			<td><img src='../../includes/img/escudo/".$partidos[$i]['visitante'].".png' style='width:30px;height:30px'/></td>
		</tr>";
	}
	 $cont .= "</table><center>";
	$tabla = "<table style='width:100%;'>
			<tr>
				<td>".$cont."</td>
				<td>".$cont."</td>
			</tr>
			<tr>
				<td>".$cont."</td>
				<td>".$cont."</td>
			</tr>
	</table>";
	$nombre = "quiniela_".$jornada.".pdf";
	$orientacion = 'L';
	
}else if(md5(2) === $tipo){
	
	if(!empty($jornada)){
		
		//usuarios que participan en esa quiniela
		$usuariosLleno = usuariosParticipantes($jornada,$Host,$User,$Pass,$dbName);
		$partidos = verPartidos($jornada,$Host,$User,$Pass,$dbName);
			
		$tabla = "<h1>Quiniela Jornada ".$jornada."</h1>
		<p class='ti12 oculta'>L = Local &nbsp;&nbsp;/&nbsp;&nbsp;  V = Visitante &nbsp;&nbsp;/&nbsp;&nbsp; E = Empate</p>";
		$tabla .= "<center><table style='width:100%;text-align:center;'>
					<tr style='background:#000000;color:#ffffff;'>
						<td style='color:#ffffff'>Participante</td>";
	
			for($i = 0; $i < count($partidos); $i++){
				$tabla .= "<td style='color:#ffffff'>
					<img src='../../includes/img/escudo/".$partidos[$i]['local'].".png' style='width:30px;height:30px'/>
					<br/>VS<br/>
					<img src='../../includes/img/escudo/".$partidos[$i]['visitante'].".png' style='width:30px;height:30px'/></td>
					<br/>".$partidos[$i]['resultado'];
				$resultados[$partidos[$i]['cve_partido']] = $partidos[$i]['resultado'];
			}
	
			$tabla .="<td style='color:#ffffff'>Total</td></tr>";
			$color=0;
			
			
			for($i = 0; $i < count($usuariosLleno); $i++){
				$tabla .= "<tr style='background:".colortr($color).";'>";
				$tabla .= "<td style='background:#000000;color:#ffffff;'>".$usuariosLleno[$i]['nombre_usu']."</td>";
				$tabla .= "".resultadosQuinielafinal($usuariosLleno[$i]['idusu'],$jornada,$resultados,$Host,$User,$Pass,$dbName)."";
				$tabla .= "</tr>";
				$color++;
	
			}
	}
	$nombre = "resultados_".$jornada.".pdf";
	$tabla .= "</table></center>";
	$orientacion = 'P';
}

	$mpdf = new mPDF('',    // mode - default ''
	
	 '',    // format - A4, for example, default ''
	
	 0,     // font size - default 0
	
	 '',    // default font family
	
	 5,    // margin_left
	
	 5,    // margin right
	
	 10,     // margin top
	
	 6,    // margin bottom
	
	 5,     // margin header
	
	 5,     // margin footer
	
	 $orientacion);  // L - landscape, P - portrait
    //$mpdf=new mPDF('win-1252','A4-L'); 
    $mpdf->WriteHTML($tabla);
    $mpdf->Output($nombre,'I');
	exit;





?>