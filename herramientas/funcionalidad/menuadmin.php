<?php
ini_set('display_errors','1');

$menu = $_POST['menu'];

if($menu == 1){
	echo "
	 <ul id='secundario'>
		<li id='11'><img src='../../includes/img/iconos/inicio.png' class='menu' /><br/><span class='titulop'>Inicio</span></li>
		<li id='12'><img src='../../includes/img/iconos/campo.png' class='menu' /><br/><span class='titulop'>Quinielas</span></li>
		<li id='13'><img src='../../includes/img/iconos/premio.png' class='menu' /><br/><span class='titulop'>Torneo</span></li>
	</ul>
	";

}else if($menu == 2){
	echo "
	<ul id='secundario'>
		<li id='20'><img src='../../includes/img/iconos/adduserb.png' class='menu' /><br/><span class='titulop'>Nuevo</span></li>
		<li id='21'><img src='../../includes/img/iconos/editauserb.png' class='menu' /><br/><span class='titulop'>Modificar</span></li>
		<li id='22'><img src='../../includes/img/iconos/maluserb.png' class='menu' /><br/><span class='titulop'>Eliminar</span></li>
	</ul>
	";

}else if($menu == 3){
	echo "
	<ul id='secundario'>
		<li id='34'><img src='../../includes/img/iconos/equipos1.png' class='menu' /><br/><span class='titulop'>Nuevo <br/>Equipo</span></li>
		<li id='30'><img src='../../includes/img/iconos/equipos1.png' class='menu' /><br/><span class='titulop'>Operaciones<br/>Equipos</span></li>
		<li id='31'><img src='../../includes/img/iconos/stadium.png' class='menu' /><br/><span class='titulop'>Nueva<br/>Jornada</span></li>
		<li id='32'><img src='../../includes/img/iconos/partido.png' class='menu' /><br/><span class='titulop'>Nuevo Partido</span></li>
		<li id='35'><img src='../../includes/img/iconos/partido.png' class='menu' /><br/><span class='titulop'>Partidos por Jornada</span></li>
		<li id='33'><img src='../../includes/img/iconos/score.jpg' class='menu' /><br/><span class='titulop'>Resultados</span></li>
	</ul>
	";
}else if($menu == 4){
	echo "
	<ul id='secundario'>
		<li id='40' class='enlacemenup'><img src='../../includes/img/iconos/inicio.png' class='menu' /><br/><span class='titulop'>Nueva</br>Quiniela</span></li>
		<li id='41' class='enlacemenup'><img src='../../includes/img/iconos/campo.png' class='menu' /><br/><span class='titulop'>Modificar</br>Quiniela</span></li>
		<li id='42' class='enlacemenup'><img src='../../includes/img/iconos/premio.png' class='menu' /><br/><span class='titulop'>Eliminar</br>Quiniela</span></li>
		<li id='43' class='enlacemenup'><img src='../../includes/img/iconos/tarjetas.png' class='menu' /><br/><span class='titulop'>Puntos</br>por</br>Usuario</span></li>
	</ul>
	";
}else if($menu == 5){
	echo "
	<ul id='secundario'>
		<li id='50' class='enlacemenup'><img src='../../includes/img/iconos/campopdf2.png' class='menu' /><br/><span class='titulop'>Quiniela</span></li>
		<li id='51' class='enlacemenup'><img src='../../includes/img/iconos/scorepdf2.png' class='menu' /><br/><span class='titulop'>Resultados</span></li>
	</ul>
	";

}else if($menu == 6){
	//echo "
	//<ul id='secundario'>
	//	<li id='50' class='enlacemenup'><img src='../../includes/img/iconos/inicio.png' class='menu' /><br/><span class='titulop'>Quiniela</span></li>
	//	<li id='51' class='enlacemenup'><img src='../../includes/img/iconos/campo.png' class='menu' /><br/><span class='titulop'>Resultados</span></li>
	//</ul>
	//";
	echo "cerrar sesion";

}else if($menu == 20){
	//agregar usuario
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>	
	 <div id='ventana' title='Usuarios'></div>
	 <form id='fagregar' enctype='multipart/form-data' method='POST' action='../../herramientas/funcionalidad/operacionesadminusuario.php'><table class='tb_100 oculta'>
		
		<tr>
			<td colspan='2' style='text-align:left'><h1>Nuevo Usuario</h1></td>
			<input type='hidden' id='operacion' name='operacion' value='1'/>
		</tr>
		<tr>
			<td colspan='7' ><div id='nota' ></div></td>
		</tr>
		<tr>
			<td><label for='nombre' >Nombre(s)</label></td>
			<td><input type='text' name='nombre' id='nombre' class='campoform requerido letra'/></td>
			<td><label for='ap'>A. Paterno</label></td>
			<td><input type='text' name='ap' id='ap' class='campoform requerido letra'/></td>
			<td><label for='am'>A. Materno</label></td>
			<td><input type='text' name='am' id='am' class='campoform requerido letra'/></td>
			<td><input type='button' name='agregar' value='Agregar' id='agregar' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='telefono'>Telefono</label></td>
			<td><input type='text' name='telefono' id='telefono' class='campoform numeros'/></td>
			<td><label for='correo'>Correo</label></td>
			<td><input type='text' name='correo' id='correo' class='campoform correo'/></td>
			<td><label for='fnac'>Fecha de Nacimiento</label></td>
			<td><input type='text' name='fnac' id='fnac' class='campoform fecha'/></td>
			<td><input type='reset' name='limpiar' value='Limpiar' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='usuario'>Usuario</label></td>
			<td><input type='text' name='usuario' id='usuario' class='campoform requerido latino'/></td>
			<td><label for='clave'>Contrase&ntilde;a</label></td>
			<td><input type='password' name='clave' id='clave' class='campoform requerido latino'/></td>
			<td><label for='clave2'>Confirma Contrase&ntilde;a</label></td>
			<td><input type='password' name='clave2' id='clave2' class='campoform requerido latino'/></td>
			<td><input type='button' name='cancelar' value='Cancelar' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='estado'>Estado</label></td>
			<td><select name='estado' id='estado' class='campoform listas requerido'>
					<option value='Activo'>Activo</option>
					<option value='Inactivo'>Inactivo</option>
				</select>
			</td>
			<td><label for='rol'>Rol</label></td>
			<td><select name='rol' id='rol' class='campoform listas requerido'>
				<option value='user'>Usuario</option>
				<option value='admin'>Adminiatrador</option>
				</select>
			</td>
			<td colspan='2' id='validaciones'></td>
			<td><input type='button' name='verusuarios' id='verusuarios' value='Ver Usuarios' class='boton' /></td>
		</tr>
		<tr>
			<td><label for='perfil'>Imagen de perfil</label></td>
			<td colspan='2'>
				<input type='file' name='perfil' id='perfil' class='boton campoform'/>
			</td>
			<td colspan='2'>
				<p id='msgimg'></p>
			</td>
		</tr>
	 </table>
	 </form>
	 
	 <div id='uagregados' class='resultadospost oculta' style='display:none;'>
		
		<table class='tb_100' id='tuagregados'>
			<tr><td colspan='10'><h1>Usuarios Agregados</h1></td></tr>
			
		</table>
	 </div>
	 </center>
		<script>
		$( '#ventana' ).dialog({
				modal: true,
				autoOpen: false,
				width: 900,
				height: 700,
				draggable: false,
				resizable: false,
				open: function() {
					  $('.ui-dialog-titlebar-close').hide('blind');
				},
				buttons: {
				  Ok: function() {
					$(this).dialog( 'close' );
				  }
				}
		  });
		</script>
	";
	
	echo utf8_encode(" <script>
		$('.letra').on('keyup',function(){
	   var normal = $(this).val().toUpperCase();
	   normal = normal.replace(/[Á]/g, 'A');
	   normal = normal.replace(/[É]/g, 'E');
	   normal = normal.replace(/[Í]/g, 'I');
	   normal = normal.replace(/[Ó]/g, 'O');
	   normal = normal.replace(/[Ú]/g, 'U');
	   normal = normal.replace(/[\\n\\r\\t]/g, '');
	   normal = normal.replace(/[^A-Z0-9%\\-,.Ñ\\s]/g, '');
	   $(this).val(normal);
   });
	 </script>");
}else if($menu == 21){
	//Modificar Usuario
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	 <table class='tb_100 oculta' style='width:35%;'>
		<tr>
			<td><label>Selecciona usuario<br/> a Editar </label></td>
			<td style='width:auto;'>
				<center><select id='usuariosedit' name='usuariosb' class='campoform listas' >
				<option>Seleccione Usuario Editar</option>
				</select></center>
			</td>
		</tr>
	 </table>		
	<div id='modusu'></div></center>
	";
}else if($menu == 22){
	//Eliminar usuario
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	 <table class='tb_100 oculta' style='width:35%;'>
		<tr>
			<td><label>Selecciona usuario<br/> a Eliminar </label></td>
			<td>
				<select id='usuariosdel' name='usuariosb' class='campoform listas' >
					<option>Seleccione Usuario Elimin</option>
				</select>
			</td>
		</tr>
	 </table>		
	<div id='modusu'></div>
	</center>
	
	";
}else if($menu == 30){
	//Operaciones Equipos
	include "../seguridad/configdb.php";
	include_once "../clases/Equipo.class.php";
	
	$equipo = new Equipo($Host,$User,$Pass,$dbName);
	$equipo->DBMS();
	$equipo->setBase();
	$rsEquipo = $equipo->mostrarTablaEquipos();
	$posicion= 1;
	$i=1;
	
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	<div id='mensaje'></div>
	<table class='tb_100 oculta'>
		<tr class='cabecera'>
			<td colspan='10' style='font-size:1em;text-align:left;'>&nbsp;Administraci&oacute;n de Equipos</td>
			<td colspan='3' style='text-align:right;'>
				<button name='actualizare' id='actualizare' class='bactualiza' >Actualizar</button>
				<button name='nuevoequipo' id='nuevoequipo' class='balta' >Agregar Equipo</button>
			</td>
		</tr>
		<tr class='cabecera'>
			<td colspan='13' ><div id='nota' ></div></td>
		</tr>
		<tr class='cabecera' style='font-size:.8em;'>
			<td>&nbsp;Equipo</td>
			<td>Nombre</td>
			<td>Estadio</td>
			<td>Liga</td>
			<td>JJ</td>
			<td>JG</td>
			<td>JE</td>
			<td>JP</td>
			<td>GF</td>
			<td>GC</td>
			<td>DG</td>
			<td>Ptos.</td>
			<td></td>
		</tr>
		<tr class='nuevoEquipof' style='background:rgba(255,255,255,0.6);display:none;'>
			<td></td>
			<td><input type='text' name='nome0' id='nome0' class='campoform2 n'/></td>
			<td><input type='text' id='estadio0' name='estadio0' class='campoform2  n' /></td>
			<td><center>
				<select class='campoform2' name='liga0' id='liga0'> 
					<option value='1'>Liga MX</option>
					<option value='2'>Segunda Divici&oacute;n</option>
					<option value='3'>Liga Espa&ntilde;ola</option>
					<option value='5'>Liga Inglesa</option>
				</select></center>
			</td>
			<td style='width:45px;'><input type='number' class='campoform2 n ' disabled='true' name='jj0' id='jj0' value='0'/></td>
			<td style='width:45px;'><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='jg0' id='jg0' value='0'/></td>
			<td style='width:45px;'><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='je0' id='je0' value='0'/></td>
			<td style='width:45px;'><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='jp0' id='jp0' value='0'/></td>
			<td style='width:45px;'><input type='number' onchange='difGoles(0);' class='campoform2 n ' name='gf0' id='gf0' value='0'/></td>
			<td style='width:45px;'><input type='number' onchange='difGoles(0);' class='campoform2 n ' name='gc0' id='gc0' value='0'/></td>
			<td style='width:45px;'><input type='text' class='campoform2 n' disabled='true' name='dif0 ' value='0' id='dif0'/></td>
			<td style='width:45px;'><input type='text' class='campoform2 n' disabled='true' name='tot0 ' value='0' id='tot0'/></td>
			<td>
				<button value='Agregar' name='agregarequipo' id='agregarequipo' class='bbien' >Agregar</button>
				<button value='Cancelar' name='cancelnuevoequipo' id='cancelnuevoequipo' class='bmal' >Cancelar</button>
			</td>
		</tr>
		<tr class='nuevoEquipof' style='background:rgba(255,255,255,0.6);display:none;'>
			<td colspan='13'><div id='mensg'></div></td>
		</tr>
		";
	
	 while($r=mysql_fetch_array($rsEquipo)){
    
		echo "<tr style='background:rgba(255,255,255,0.4)'>
			<td>".$r['cve_equipo']."<img src='../../includes/img/escudo/". $r['nom_equipo'] .".png' style='width:30px'/></td>
			<td><input type='text' name='nome".$r['cve_equipo']."' id='nome".$r['cve_equipo']."' value='". utf8_encode($r['nom_equipo']) ."' class='campoform2'/></td>
			<td><input type='text' id='estadio".$r['cve_equipo']."' name='estadio".$r['cve_equipo']."' value='". utf8_encode($r['estadio']) ."' class='campoform2' /></td>
			<td><center>
				<select value='". $r['liga_participa'] ."' class='campoform2' name='liga".$r['cve_equipo']."' id='liga".$r['cve_equipo']."'> 
					<option value='1'>Liga MX</option>
					<option value='2'>Segunda Divici&oacute;n</option>
					<option value='3'>Liga Espa&ntilde;ola</option>
					<option value='5'>Liga Inglesa</option>
				</select></center>
			</td>
			<td style='width:42px;'><input type='number' value='". $r['jue_jug'] ."' class='campoform2' disabled='true' name='jj".$r['cve_equipo']."' id='jj".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='number' value='". $r['jue_gan'] ."' class='campoform2' onchange='totalPuntos(".$r['cve_equipo'].");' name='jg".$r['cve_equipo']."' id='jg".$r['cve_equipo']."' /></td>
			<td style='width:42px;'><input type='number' value='". $r['jue_emp'] ."' class='campoform2' onchange='totalPuntos(".$r['cve_equipo'].");' name='je".$r['cve_equipo']."' id='je".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='number' value='". $r['jue_per'] ."' class='campoform2' onchange='totalPuntos(".$r['cve_equipo'].");' name='jp".$r['cve_equipo']."' id='jp".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='number' value='". $r['gol_fa']  ."' class='campoform2' onchange='difGoles(".$r['cve_equipo'].");' name='gf".$r['cve_equipo']."' id='gf".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='number' value='". $r['gol_con'] ."' class='campoform2' onchange='difGoles(".$r['cve_equipo'].");' name='gc".$r['cve_equipo']."' id='gc".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='text' value='".$r['diferencia_gol']."' class='campoform2' disabled='true' name='dif".$r['cve_equipo']."' id='dif".$r['cve_equipo']."'/></td>
			<td style='width:42px;'><input type='text' value='". $r['tot_puntos']."' class='campoform2' disabled='true' name='tot".$r['cve_equipo']."' id='tot".$r['cve_equipo']."'/></td>
			<td>
				<button name='actualizarequipo' id='actualizarequipo' class='bedita' >Editar Equipo</button>
				<button name='eliminarequipo' id='eliminarequipo' class='belimina' >Eliminar Equipo</button>
			</td>
		</tr>
		<script>
			$('#liga".$r['cve_equipo']."').val(". $r['liga_participa'] .");
			equipos();
		</script>
		";
					  
		$posicion++;
		$i++;
	}
                      
    echo "
    </center>
    </table><br/><br/>";

}else if($menu == 31){
	//Jornadas
	echo "<h1>Jornadas</h1>";
}else if($menu == 32){
	// Nuevo Partido
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	<form id='fagregarP' class='oculta' method='POST' action='../../herramientas/funcionalidad/operacionesadminpartidos.php'>
		<input type='hidden' name='operacion' id='operacionp' value='4'/>
		<table class='tb_100'>
			<tr>
				<td colspan='4' style='text-align:left'><h1>Nuevo Partido</h1></td>
			</tr>
			<tr>
				<div id='mensaje' style='display:none;'></div>
			</tr>
			<tr class='cabecera' style='font-size:.8em;'>
				<td><label for='locn'>Local</label></td>
				<td><label for='gl'>Gol L.</label></td>
				<td><label for='visn'>Visitante</label></td>
				<td><label for='gv'>Gol V.</label></td>
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td><select id='locn' name='locn' class='equiG campoform listas requerido'></select></td>
				<td><select name='gl' style='width:50px;' id='gl' class='campoform2 numeros listas'>
					<option value=''>Gol</option>";
					for($i = 1; $i<11;$i++){
						echo "<option value='".$i."'>".$i."</option>";
					}
				echo ";</select>
				<td><select id='visn' name='visn' class='equiG campoform listas requerido'></select></td>
				<td><select name='gv' style='width:50px;' id='gv' class='campoform2 numeros listas'>
				<option value=''>Gol</option>";
					for($i = 1; $i<11;$i++){
						echo "<option value='".$i."'>".$i."</option>";
					}
				echo ";</select></td>
			</tr>

			<tr class='cabecera' style='font-size:.8em;'>
				<td><label for='resn'>Resultado</label></td>
				<td><label for='fechan'>Fecha</label></td>
				<td><label for='horan'>Hora</label></td>
				<td><label for='jorn'>Jornada</label></td>
				
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td><select id='resn' name='resn' class='campoform listas' disabled>
						<option value=''>Resultado</option>
						<option value='local'>Local</option>
						<option value='visitante'>Visitante</option>
						<option value='empate'>Empate</option>
					</select>
				</td>
				<td><input type='text' style='background:white;' class='fecha campoform2 requerido' name='fechan' id='fechan' /></td>
				<td><input type='text' style='background:white;' class='campoform2 n requerido' name='horan' id='horan' placeholder='hh:mm:ss'/></td>
				<td><select id='jorn' name='jorn' class='campoform listas jorG requerido'></select></td>
				
			</tr>
			<tr class='cabecera' style='font-size:.8em;'>
				<td colspan='3'></td>
				<td colspan='1'>Acci&oacute;n</td>
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td >
					<div id='fl' style='width:40px;display:inline-block;vertical-align:top;height:40px;'></div>
					<div id='fvs' style='width:40px;display:inline-block;vertical-align:bottom;'></div>
					<div id='fv' style='width:40px;display:inline-block;vertical-align:top;height:40px;'></div>
				</td>
				<td colspan='2'></td>
				<td>
					<input type='button' value='Agregar' name='agregarpartido' style='font-size:12px;' id='agregarPA' class='bbien' />
					<input type='button' value='Cancelar' name='cancelnuevop' id='cancelnuevop' style='font-size:12px;' class='bmal' />
				</td>
			</tr>

		</table>
	</form>
	<script>
		equipoN();
	</script>";
}else if($menu == 33){
	//Resultados
	echo "<h1>Resultados</h1>";
}else if($menu == 34){
	//NUEVO EQUIPO
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	<form id='fagregar' class='oculta' enctype='multipart/form-data' method='POST' action='../../herramientas/funcionalidad/operacionesadminusuario.php'>
		<div id='mensaje'></div>
		<table class='tb_100'>
			<tr class='cabecera' style='font-size:.8em;'>
				<td colspan='3'>Nombre</td>
				<td colspan='3'>Estadio</td>
				<td colspan='2'>Liga</td>
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td colspan='3'><input type='text' name='nome0' id='nome0' class='campoform2 n'/></td>
				<td colspan='3'><input type='text' id='estadio0' name='estadio0' class='campoform2  n' /></td>
				<td colspan='2'><center>
					<select class='campoform2' name='liga0' id='liga0'> 
						<option value='1'>Liga MX</option>
						<option value='2'>Segunda Divici&oacute;n</option>
						<option value='3'>Liga Espa&ntilde;ola</option>
						<option value='5'>Liga Inglesa</option>
					</select></center>
				</td>
			</tr>
			<tr class='cabecera' style='font-size:.8em;'>
				<td>JJ</td>
				<td>JG</td>
				<td>JE</td>
				<td>JP</td>
				<td>GF</td>
				<td>GC</td>
				<td>DG</td>
				<td>Ptos.</td>
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td><input type='number' class='campoform2 n ' disabled='true' name='jj0' id='jj0' value='0'/></td>
				<td><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='jg0' id='jg0' value='0'/></td>
				<td><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='je0' id='je0' value='0'/></td>
				<td><input type='number' onchange='totalPuntos(0);' class='campoform2 n ' name='jp0' id='jp0' value='0'/></td>
				<td><input type='number' onchange='difGoles(0);' class='campoform2 n ' name='gf0' id='gf0' value='0'/></td>
				<td><input type='number' onchange='difGoles(0);' class='campoform2 n ' name='gc0' id='gc0' value='0'/></td>
				<td><input type='text' class='campoform2 n' disabled='true' name='dif0 ' value='0' id='dif0'/></td>
				<td><input type='text' class='campoform2 n' disabled='true' name='tot0 ' value='0' id='tot0'/></td>
			</tr>
			<tr class='cabecera' style='font-size:.8em;'>
				<td colspan='4'>Imagen del Equipo</td>
				<td colspan='3'></td>
				<td >Acci&oacute;n</td>
			</tr>
			<tr style='background:rgba(255,255,255,0.6);'>
				<td colspan='4'><input type='file' name='imgeq' class='boton campoForm'/></td>
				<td colspan='3'></td>
				<td>
					<button value='Agregar' name='agregarequipo' id='agregarequipo' class='bbien' >Agregar</button>
					<button value='Cancelar' name='cancelnuevoequipo' id='cancelnuevoequipo' class='bmal' >Cancelar</button>
				</td>
			</tr>

		</table>
	</form>
	<script>
		equipos();
	</script>
		";
}else if($menu == 35){
	//echo "Partidos por jornada";
	echo "
	<center><img src='../../includes/img/iconos/cargando.gif' id='carga' style='width:60px;display:none;'/>
	 <table class='tb_100 oculta' style='width:35%;'>
		<tr>
			<td><label>Selecciona Jornada</label></td>
			<td>
				<select id='jorpart' name='jorpart' class='campoform listas' >
					<option>Seleccione Jornada</option>
				</select>
			</td>
		</tr>
	 </table>		
	<div id='modpar'></div>
	</center>
	<script>
		partidos();
	</script>
	";
	
}else if($menu == 40){
	//nueva quiniela
	echo "<h1>Nueva quiniela</h1>";
}else if($menu == 41){
	//modificar quiniela
	echo "<h1>Modificar Quiniela</h1>";
}else if($menu == 42){
	//eliminar quiniela
	echo "<h1>Eliminar Quiniela</h1>";
}else if($menu == 43){
	//puntuacion usuarios
	echo "<h1>Puntuacion Usuarios</h1>";
	
}else if($menu == 50){
	//Reporte Quiniela
	include "../seguridad/configdb.php";
	include_once "../clases/query.php";
	$jornadas = verQuinielas($Host,$User,$Pass,$dbName);
	echo "<div class='marcogral'>
		<h1>Quiniela Semanal</h1>
		<div class='marcodoble'>";
	
	if($jornadas[0]['cve_jornada'] === ''){
		echo "<div class='notaInfo'>No hay Quinielas llenas.</div>";
	}else{
		for($i = 0; $i<count($jornadas);$i++){
			echo "<a class='listado' href='../../herramientas/funcionalidad/reportes.php?jrnd=".md5($jornadas[$i]['cve_jornada'])."&tp=".md5(1)."' target='reporte'>".$jornadas[$i]['numero_jornada']."</a>";
		}
	}
	echo "</div>
		<div class='marcodoble'>
			<center>
				<iframe name='reporte' class='frame'></iframe><br/>
			</center>
		</div><br/>
	</div>
	<script>
		var alto = $(window).height()/1.4;
		var ancho = $( window ).width()/2.6;
		$('iframe[name=reporte]').css({width: + ancho + 'px',height: + alto + 'px'});
	</script>";
	
}else if($menu == 51){
	//Reporte Resultados
	include "../seguridad/configdb.php";
	include_once "../clases/query.php";
	$jornadas = jorQuiniela($Host,$User,$Pass,$dbName);
	echo "<div class='marcogral'>
		<h1>Reporte de resultados de Quiniela</h1>
		<div class='marcodoble'>";
	
	if($jornadas[0]['cve_jornada'] === ''){
		echo "<div class='notaInfo'>No hay Quinielas llenas.</div>";
	}else{
		for($i = 0; $i<count($jornadas);$i++){
			echo "<a class='listado' href='../../herramientas/funcionalidad/reportes.php?jrnd=".md5($jornadas[0]['cve_jornada'])."&tp=".md5(2)."' target='reporte'>".$jornadas[0]['cve_jornada']."</a>";
		}
	}
	echo "</div>
		<div class='marcodoble'>
			<center>
				<iframe name='reporte' class='frame'></iframe><br/>
			</center>
		</div><br/>
	</div>
	<script>
		var alto = $(window).height()/1.8;
		var ancho = $( window ).width()/2.7;
		$('iframe[name=reporte]').css({width: + ancho + 'px',height: + alto + 'px'});
	</script>";
}


?>