<?php
header('Content-Type: text/html; charset=UTF-8');
$tab    = chr(9);
$salto  = chr(13).chr(10);
$fCSS   = $salto.$tab.'<link type="text/css" rel="stylesheet" href="includes/css/%s"/>';
$fJS    = $salto.$tab.'<script type="text/javascript" src="includes/js/%s"></script>';
$fIMG   = $salto.$tab.'<img src="includes/img/fondo/%s" class="fondo"/>';
$pIMG   = $salto.$tab.'<img src="includes/img/perfil/%s" class="imgPerfil"/>';
$fMENU  = $salto.$tab.$tab.$tab.'<li><a %s><p>%s</p></a></li>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
		<meta charset="utf8">
        <title><?php echo $titulo; ?></title>
		<?php
		if(!empty($css))
		{
			foreach($css as $arch)
			{
				echo sprintf($fCSS,$arch);
			}
		}
		if(!empty($js))
		{
			foreach($js as $arch)
			{
				echo sprintf($fJS,$arch);
			}
		}
		?>
	
    </head>
    <body>
		<?php
		echo sprintf($fIMG,$imgFONDO).$salto;
		?>
		<div class="ventana">
			<div class="cabecera trans">
				<div class="iconoPrin degrad1">
					<img src="includes/img/balon1.png" class="icono trans" id="icoPrinc"/>
					<div class="notas"><?php /*area de notas informativas (funcionalidad con js)*/ ?></div>
				</div>
				<div class="cabTitulo color1">
					<p>
						<?php 
							echo $titulo; 
							if($_SESSION['AUTEN']){
								echo '<span class="nombreUsu"><a href="?p=principal&m=usuario&v=edit">'.$_SESSION['NOMBRE'].' '.sprintf($pIMG,$_SESSION['IMGPER']).'</a></span>';
							}
						?> 
					</p>
				</div>
				<div class="menu color2" id="menuPrin">
					<?php
					if(!empty($menu))
					{
						echo '<ul class="trans">';
						foreach($menu as $nombre => $datos)
						{
							if(is_array($datos))
							{
								$atributo = '';
								foreach($datos as $attr => $valor)
								{
									$atributo.= ' '.$attr.'="'.$valor.'"';
								}
								echo sprintf($fMENU,$atributo,$nombre);
							}
							else
							{
								echo sprintf($fMENU,'href="'.$datos.'"',$nombre);
							}
						}
						echo '</ul>';
						echo $salto;
					}
					?>
				</div>
				<span class="responsivo menuDesp color1"> <i class="icono-hamburger"></i></span>
			</div>
			<div class="contenedor">
				<div class="contenido">
					<?php
						include_once $cont;
					?>
				</div>
			</div>
		</div>
		<?php
		if(!empty($jsPie))
		{
			foreach($jsPie as $arch)
			{
				echo sprintf($fJS,$arch);
			}
			echo $salto;
		}
		?>
        <!--[if gte IE 9]>
            <style type="text/css">
                [class^="degrad"]{
                    filter: none;
                }
            </style>
        <![endif]-->
    </body>
</html>