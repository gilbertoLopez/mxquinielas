<!DOCTYPE html>
<html lang="es">
<head>
	<title>Quinielas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width,initial-scale=1"/>
	<link rel="shortcut icon" type="image/x-icon" href="en.ico"/>
	<script src="jquery/jquery.min.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<link rel="stylesheet" href="css/flexslider.css"/>
	<link rel="stylesheet" href="css/estilos.css"/>
	<script type="text/javascript">
		$(window).load(function() {
			$('.flexslider').flexslider();
		});
	</script>
</head>
<body>
	<section id="icp">
	
		<section id="ici">
			<center><img src="img/iconos/balon.png" class="icolo"/></center>
			<form id="flogin" action="seguridad/valida.php" method="POST">
				<p class="ti1"> Ingresa tus datos para accesar a tu cuenta personal de quinielas</p>
				<p class="ti2">Usuario:</p>
                <input type="text" class="txt" name="usuario" placeholder="Usuario" required/><br/>
                <p class="ti2">Contrase&ntilde;a:</p>
                <input type="password" class="txt" name="contrasena" placeholder="Contrase&ntilde;a" required/><br/><br/>
                <input type="submit" id="boton" name="aceptar" value="Entrar" /><br/><br/>
                <center><a href="registro.php">Registrate Ya...</a></center><br/><br/>
			</form>
		</section>
		
		<section id="icc">
			<section id="slideic">	
				<center>
				<article id="galeria-inicio">
					<div class="flexslider">
						<ul class="slides">
							<li>
								<img src="img/mx.jpg" />
								<p class="flex-caption">Nos Preocupamos por Mantener la Salud de los que más Quieres.</p>
							</li>
							<li>
								<img src="img/blue.jpeg" />
								<p class="flex-caption">Nos Preocupamos por Mantener la Salud de los que más Quieres.</p>
							</li>
							<li>
								<img src="img/balon.png" />
								<p class="flex-caption">Contamos con una amplia variedad en Anlisis Clínicos.</p>
							</li>
							<li>
								<img src="img/blue.jpeg" />
								<p class="flex-caption">Nos Preocupamos por Mantener la Salud de los que más Quieres.</p>
							</li>
						</ul>
					</div>
				</article>
				</center><br/><br/>
				
				
			</section>
		</section>
		
		<section id="icd">
			index contenido derecha
			index contenido derecha
			index contenido derecha
			index contenido derecha
		</section>
	
	
	
	</section>
	
	
</body>

</html>