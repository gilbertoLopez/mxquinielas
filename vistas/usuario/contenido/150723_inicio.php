<?php
include_once 'herramientas/funcionalidad/query.php';
$datos = tablaGeneral();
?>
<div id="INICIO">
    <div class="fIzq trans">
        <div class="infoNotas color4" id="ganSema">
            <h3 class="color2">Ganadores Semanales</h3>
            <div>
                <p>Jornada 1</p>
                <p>Jornada 2</p>
                <p>Jornada 3</p>
                <p>Jornada 4</p>
                <p>Jornada 5</p>
                <p>Jornada 6</p>
                <p>Jornada 7</p>
                <p>Jornada 8</p>
                <p>Jornada 9</p>
                <p>Jornada 10</p>
                <p>Jornada 11</p>
                <p>Jornada 12</p>
            </div>
        </div>
    </div>
    <div class="fDer trans">
        
        <div class="infoNotas2 color4">
            <table class="tbEquipos">
                <thead>
                    <tr>
                        <th colspan="4" class="color2">
                            Tabla General del Torneo
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $n = 1;
                    foreach($datos as $equipos)
                    {
                        echo '<tr>';
                        echo '<td>'.$n.'</td>';
                        echo '<td><img src="includes/img/escudo/'.$equipos['nom_equipo'].'.png" title="'.$equipos['nom_equipo'].'" class="iconoEquipo"/></td>';
                        echo '<td><span class="soloMovil">'.$equipos['nom_equipo'].'</span></td>';
                        echo '<td>'.$equipos['tot_puntos'].'</td>';
                        echo '</tr>';
                        $n++;
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>