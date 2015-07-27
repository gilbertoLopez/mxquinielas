<?php
include_once 'herramientas/funcionalidad/query.php';
$datos = jornada();
?>
<div id="QUIN">
    <div>
        <div class="infoNotas parcial color4 trans">
            <form method="post" action="herramientas/funcionalidad/mostrarQuinielas.php" type="json" id="fQuin" class="ajax" for="areaQuin">
                <table>
                    <tr>
                        <td colspan="2">
                            <label for="cJornada">Jornada</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <select id="cJornada" name="cJornada" for="fQuin">
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
                        <td>
                            <button type="button" class="transp" id="actResult"><i class="icono-reset"></i></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div>
        <div class="infoNotas parcial2 color4 OCULTO trans" id="areaQuin">
            <div></div>
        </div>
    </div>
</div>