<?php
session_start();
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

try{
    $respuesta['accion'] = 'torneo';
    $partidos = verPartidos($jornada);
    $valCombo = array('local','empate','visitante');
    $CONTENIDO[$X++] = '<table class="tbPartidosR"><tr><th>Cancelar</th><th>Equipo Local</th><th>Resultado</th><th>Equipo Visitante</th><th>Accion</th></tr></table><div class="areaScroll">';
    foreach($partidos as $indice => $valor)
    {
        extract($valor);
        $CONTENIDO[$X++] = '<form method="post" action="herramientas/funcionalidad/resultadoPartido.php" type="json" class="fPartidos">'.
                 '<table class="tbPartidosR"><tr><td rowspan="3"><input type="checkbox" name="cancelar" value="1" class="chk_cancelar" for="txta_'.$idpart.'"/></td><td><input type="hidden" name="idpart" value="'.$idpart.'"/><label for="gol_l_'.$idel.'"><img class="imgPartido" src="includes/img/escudo/'.$elocal.'.png"/>'.$elocal.'</label></td>'.
                 '<td rowspan="2"><select name="resultado" id="p_'.$idpart.'" class="requerido"><option vlaue=""></option>';
        foreach($valCombo as $rCombo){
            $select = ($resultado_partido == $rCombo)? ' selected="selected"' : '';
            $CONTENIDO[$X++] = '<option value="'.$rCombo.'"'.$select.'>'.strtoupper($rCombo).'</option>';
        }
        $CONTENIDO[$X++] = '</select></td><td><label for="gol_v_'.$idev.'"><img class="imgPartido" src="includes/img/escudo/'.$evisit.'.png"/>'.$evisit.'</label></td><td rowspan="3"><button type="submit" class="boton degrad2 submit"> Guardar Partido </button></td></tr>'.
                 '<tr><td><input type="number" name="gol_local" id="gol_l_'.$idel.'" value="'.$gollocal.'" min="0" max="15" for="p_'.$idpart.'" class="local requerido"/></td>'.
                 '<td><input type="number" name="gol_visit" id="gol_v_'.$idev.'" value="'.$golvisitante.'" min="0" max="15" for="p_'.$idpart.'" class="visitante requerido"/></td></tr>'.
                 '<tr><td colspan="3"><textarea name="motivoC" id="txta_'.$idpart.'" placeholder="Motivo por el cual se cancela el partido"></textarea></td></tr></table></form>';
    }
    $CONTENIDO[$X++] = '</div><style>table.tbPartidosR{border-collapse:collapse;border-bottom:solid 1px #FFF;}table.tbPartidosR td,table.tbPartidosR th{width:20%;padding:6px 0;}.areaScroll{width:100%;height:400px;overflow:auto;}textarea{width:90%;resize: none; display:none;}button[type="submit"]{font-size:13px;width:70%;}.imgPartido{display:block;width:40px;height:40px;margin:5px auto;}</style>';
}
catch(Exception $e){
    $respuesta['estatus'] = $e->getMessage();
    $CONTENIDO = array();
}
$respuesta['contenido'] = implode('',$CONTENIDO);
echo json_encode($respuesta);
?>