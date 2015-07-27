<?php
include_once 'herramientas/funcionalidad/query.php';
$datos = jornada();
?>
<div id="QUIN">
    <div>
        <div class="infoNotas parcial color4 trans">
            <form method="post" action="herramientas/funcionalidad/mostrarPartidos.php" type="json" id="fTorn" class="ajax" for="areaTorn">
                <table>
                    <tr>
                        <td colspan="2">
                            <label for="cJornada">Jornada</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <select id="cJornada" name="cJornada" for="fTorn">
                                <option value="">Seleccionar Jornada</option>
                                <?php
                                foreach($datos as $jornada)
                                {
                                    list($id,$jorn) = $jornada;
                                    echo '<option value="'.$id.'">'.$jorn.'</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div>
        <div class="infoNotas parcial2 color4 OCULTO trans" id="areaTorn">
            <div></div>
        </div>
    </div>
</div>