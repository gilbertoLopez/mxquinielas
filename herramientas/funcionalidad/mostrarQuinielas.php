<?php
session_start();
date_default_timezone_set('America/Mexico_City');
require_once '../config/configdb.php';
require_once '../clases/Conexion.class.php';
require_once 'query.php';
$respuesta = array('estatus'=>'OK','accion'=>'','contenido'=>'');
$meses     = array('','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE');
$meses2    = array('','ENE','FEB','MAR','ABR','MAO','JUN','JUL','AGOS','SEP','OCT','NOV','DIC');
$CONTENIDO = array();
$X         = 0;
$jornada   = $_POST['cJornada'];
$idusuario = $_SESSION['IDUSU'];
$imgEqui   = '<img class="iconoEquipo" src="includes/img/escudo/%s.png" title="%1$s"/>';
try{
    $valida    = validaQuinielaLLena($jornada,$idusuario);
    $valida2   = validaPeriodo($jornada);
    
    if( !empty($valida) || empty($valida2) )
    {
        $respuesta['accion'] = 'mostrarQuin';
        $equipos  = partidos($jornada);
        $quiniela = quinielasUsu($jornada);
        if(!empty($quiniela))
        {
            $length = (count($equipos)) / 100 ;
            $CONTENIDO[$X++] = '<table class="tbEquipos"><thead>';
            $trDias = '<tr><th rowspan="3" class="bordeDer2 color2 verQuin">Usuario</th>';
            $trPart = '<tr>';
            $trHrPart = '<tr>';
            $resultado = array();
            $aux  = null;
            $aux2 = 0;
            $tr = '';
            $idQ = array();
            $cancel = array();

            foreach ($equipos as $value) {
                $idQ[] = $value['cve_partido'];
                $resultado[$value['cve_partido']] = $value['resultado'];
                if($aux != $value['fecha']){
                    $trDias = sprintf($trDias,$aux2);
                    $trDias .= '<th colspan="%d" class="bordeDer2 color2 verQuin">' . $value['fecha'] . '</th>';
                    $aux  = $value['fecha'];
                    $aux2 = 0;
                }
                if($value['stpartido'] == 0){
                    $cancel[] = $value['cve_partido'];
                }
                $aux2++;
                $isNow = date('Y-m-d',strtotime($value['fecha'])) == date('Y-m-d') ? true : false;
                $valid = date('Y-m-d',strtotime($value['fecha'])) > date('Y-m-d') ? true : false;
                $clase = empty($value['stpartido'])? ' cancelado' : '';
                $trPart .= '<td class="bordeDer'.$clase.'" style="width:'.$length.'%;">'.sprintf($imgEqui,$value['elocal']) . sprintf($imgEqui,$value['evisit']).'</td>';
                $tkeeperClass = $isNow ? 'timekeeper' : '';
                $result = empty($value['resultado']) ? '' : $value['resultado'].'<br/>'.$value['gollocal'].' - '.$value['golvisitante'];
                $hPart = date('H:i:s',strtotime($value['hora']));
                $label = $valid ? $hPart : $result;
                $label = empty($value['stpartido']) ? 'cancelado' : $label;
                $trHrPart .= '<td class="date bordeDer"><span id="result_'.$value['cve_partido'].'" class="'.$clase.'">'.$label.'</span><span class="'.$tkeeperClass.'" data-time="'.$hPart.'"></span></td>';
            }
            $trDias = sprintf($trDias,$aux2);
            $trDias .= '<th rowspan="3" class="bordeDer2 color2 verQuin">Total</th></tr>';
            $CONTENIDO[$X++] = $trDias.$trPart.'</tr>'.$trHrPart.'</tr></thead><tbody>';
            $total  = count($quiniela);
            $total2 = count($idQ);
            foreach($quiniela as $key => $value){
                $aux2 = 0;
                $CONTENIDO[$X++] = '<tr><td class="bordeDer">'.$value['nombre'].'</td>';
                for($y = 0; $y < $total2; $y++){
                    $class = !empty($value[$idQ[$y]]['real']) ? 'correcto' : 'incorrecto';
                    $class = !empty($resultado[$idQ[$y]])     ? $class : 'espera';
                    $class = in_array($idQ[$y],$cancel)       ? 'cancelado' : $class ;
                    $CONTENIDO[$X++] = '<td class="'.$class.'">'.$value[$idQ[$y]]['resultado'].'</td>';
                    $aux2 += $value[$idQ[$y]]['real'];
                }
                $CONTENIDO[$X++] = '<td class="bordeIzq total" data-value="'.$aux2.'">'.$aux2.'</td>';
            }
            $CONTENIDO[$X++] = '</tbody></table>';
        }else
        {
            $CONTENIDO[$X++] = '<p> No hay participantes en esta Jornada</p>';
        }
    }else
    {
        $respuesta['accion'] = 'llenarQuin';
        $quin = quiniela($jornada);
        $fMostrar = '';
        $CONTENIDO[$X++] =  '<form method="post" action="herramientas/funcionalidad/agregarQuinielas.php" type="json" id="fQuinUsua">';
        $CONTENIDO[$X++] =  '<input type="hidden" name="idJornada" value="'.$quin[0]['idjorn'].'"/>';
        
        $CONTENIDO[$X++] =  '<p class="color2 titulo">'.$quin[0]['jorn'].'</p>';
        $CONTENIDO[$X++] =  '<table class="tbEquipos">';
        $CONTENIDO[$X++] =  '<thead><tr><th> Hora </th><th> Comod&iacute;n </th><th> Local </th><th> Resultado </th><th> Visitante </th></tr></thead>';
        $CONTENIDO[$X++] =  '<tbody>';
        foreach($quin as $partidos)
        {
            extract($partidos);
            if($fMostrar != $fecha)
            {
                list($a,$m,$d) = explode('-',$fecha);
                $m = (int) $m;
                $CONTENIDO[$X++] =  '<tr><td colspan="5" class="color3"><p>'.$d.' de '.$meses[$m].' del '.$a.'</p></td></tr>';
                $fMostrar = $fecha;
            }
            $cve    = 'select-'.$id;
            $cveCom = 'table-'.$id;
            $cveChk = 'comodinCHK-'.$id;
            $CONTENIDO[$X++] =  '<tr class="areaPartido" data-status="'.$stpartido.'">';
            $msg = empty($stpartido) ? 'Partido cancelado, motivo: '.$motivo_cancel : $hora;
            $CONTENIDO[$X++] =  '<td class="bordeDer color3" style="width:120px !important; padding:5px;">'.$msg.'</td>';
            $CONTENIDO[$X++] =  '<td><p><input type="radio" id="'.$id.'" name="comodin" value="'.$id.'"/></p></td>';
            $CONTENIDO[$X++] =  '<td><label for="'.$cve.'" value="local"><p><img src="includes/img/escudo/'.$elocal.'.png" title="'.$elocal.'" class="iconoEquipo"/></p><p>'.$elocal.'</p></label></td>';
            $CONTENIDO[$X++] =  '<td class="areaSeleccion">'.
                    '<select id="'.$cve.'" name="'.$cve.'" class="requerido" title="El partido '.$elocal.' VS '.$evisit.' es requerido"><option> </option><option value="local">Local</option><option value="empate">Empate</option><option value="visitante">Visitante</option></select>'.
                    '<table id="'.$cveCom.'" class="OCULTO"><tr class="tr-td33"><td><label>Local</label></td><td><label>Empate</label></td><td><label>Visitante</label></td></tr><tr><td><input type="checkbox" name="'.$cveChk.'[]" value="local" class="comodin2" for="'.$cve.'"/></td><td><input type="checkbox" name="'.$cveChk.'[]" value="empate" class="comodin2" for="'.$cve.'"/></td><td><input type="checkbox" name="'.$cveChk.'[]" value="visitante" class="comodin2" for="'.$cve.'"/></td></tr></table>'.   
                 '</td>';
            $CONTENIDO[$X++] =  '<td><label for="'.$cve.'" value="visitante"><p><img src="includes/img/escudo/'.$evisit.'.png" title="'.$evisit.'" class="iconoEquipo"/></p><p>'.$evisit.'</p></label></td>';
            $CONTENIDO[$X++] =  '</tr>';
        }
        $CONTENIDO[$X++] =  '<tr><td colspan="5"><button type="submit" id="enviarQuin" name="guardar" class="boton degrad2"> Guardar </button></td></tr>';
        $CONTENIDO[$X++] =  '</tbody></table>';
        $CONTENIDO[$X++] =  '<input type="hidden" id="comodinComp" class="requerido" value="" title="Es necesario completar un partido con comodin"/>';
        $CONTENIDO[$X++] =  '</form>';
    }
}
catch(Exception $e){
    $respuesta['estatus'] = $e->getMessage();
    $CONTENIDO = array();
}
$respuesta['contenido'] = implode('',$CONTENIDO);

echo json_encode($respuesta);
?>