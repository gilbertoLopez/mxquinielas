<?php
$class_flogin = (!empty($_SESSION['ERROR']))? '' : ' OCULTO';
?>
<div class="info degrad1<?php echo $class_flogin; ?>" id="accesoUSU">
	<button type="button" class="degrad2 boton fDer cerrar"> X </button>
    <form id="flogin" action="herramientas/seguridad/acceso.php" method="POST">
        <p class="ti1">
            Ingresa tus datos para accesar a tu cuenta personal de quinielas
        </p>
        <?php
              echo (!empty($_SESSION['ERROR']))? '<p class="msjAlert">'.$_SESSION['ERROR'].'</p>' : '';
              unset($_SESSION['ERROR']);
        ?>
        <div>
			<label for="usuario" class="ti2">
					Usuario:
			</label>
			<input type="text" class="txt trans" name="usuario" id="usuario" placeholder="Usuario" required="required" autofocus="true"/>
			<label for="contrasena" class="ti2">
					Contrase&ntilde;a:
			</label>
			<input type="password" class="txt trans" name="contrasena" id="contrasena" placeholder="Contrase&ntilde;a" required="required"/>
			<input type="submit" id="boton" name="aceptar" value="Entrar" class="boton degrad2 submit"/>
        </div>
    </form>
    
</div>


