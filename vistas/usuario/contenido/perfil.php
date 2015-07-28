<?php
	include_once 'herramientas/funcionalidad/query.php';
	$datos = getDatosUsuario();
	extract($datos);
?>
<section class="contenedor color2">
	<article>
		<form method="post" id="frmUsuario">
			<div class="radial" id="changeFile" style="display:none;">
				<img src="./includes/img/perfil/<?php echo $_SESSION['IMGPER']; ?>"/>
			</div>
			<input type="hidden" id="validUser" value="0"/>
			<input type="file" id="filePerfil" class="hidden"/>
			<fieldset>
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre_usu; ?>"/>
			</fieldset>
			<fieldset>
				<label for="apellidopa">Apellido Paterno</label>
				<input type="text" name="apellidopa" id="apellidopa" placeholder="Apellido Paterno" value="<?php echo $apellidopa_usu; ?>"/>
			</fieldset>
			<fieldset>
				<label for="apellidoma">Apellido Materno</label>
				<input type="text" name="apellidoma" id="apellidoma" placeholder="Apellido Materno" value="<?php echo $apellidoma_usu; ?>"/>
			</fieldset>
			<fieldset>
				<label for="telefono">Telefono</label>
				<input type="text" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $tel_usu; ?>"/>
			</fieldset>
			<fieldset>
				<label for="email">Correo electronico</label>
				<input type="text" name="email" id="email" placeholder="Correo electronico" value="<?php echo $correo_usu; ?>"/>
			</fieldset>
			<fieldset>
				<label for="fechaNac">Fecha de nacimiento</label>
				<input type="text" name="fechaNac" id="fechaNac" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($nacimiento)); ?>"/>
			</fieldset>
			<fieldset class="anchor">
				<label for="changeUser">Cambiar usuario y / o contrase&ntilde;a </label>
				<input type="checkbox" name="changeUser" id="changeUser" value="1"/>
			</fieldset>
			<div id="divChangeUser" style="display: none">
				<fieldset>
					<label for="usuario">Usuario</label>
					<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $nom_user; ?>"/>
				</fieldset>
				<fieldset>
					<label for="clave">Contrase&ntilde;a actual</label>
					<input type="password" name="clave" id="clave" placeholder="Contrase&ntilde;a"/>
				</fieldset>
				<fieldset>
					<label for="clave">Nueva contrase&ntilde;a</label>
					<input type="password" name="clave1" id="clave1" placeholder="Contrase&ntilde;a"/>
				</fieldset>
				<fieldset>
					<label for="clave2">Valida nueva contrase&ntilde;a</label>
					<input type="password" name="clave2" id="clave2" placeholder="Valida Contrase&ntilde;a"/>
				</fieldset>
			</div>
			<div style="padding-top: 10px; clear: both;">
				<button type="submit" id="btnEditar" class="frmButton degrad2">Actualizar</button>
				<input type="reset" value="Limpiar" class="frmButton degrad2"/>
			</div>
		</form>
	</article>
</section>
