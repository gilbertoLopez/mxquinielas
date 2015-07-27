//-----------------------PARTIDOS-----------------------------------------------------------------------
function equipoN(){
	$('.boton').button();
    $('.listas').chosen();
	$(document).tooltip();
	$('.fecha').datepicker(confDatePick3);
	comboPartidosF();
	
	$('#locn,#visn').on('change',function(){
		var loc = $('#locn').val();
		var vis = $('#visn').val();
		//alert(loc);
		//alert(vis);
		if (loc != '' && vis != '') {
			if (loc == vis) {
				alert("El Equipo Visitante no puede ser el mismo que el Equipo Local");
				$('#visn').val('').trigger('chosen:updated');
				$('#fl,#fvs,#fv').html('');
			}else{
				var floc = "";
				$("#locn option:selected").each(function(){
					floc += $( this ).text();
				 });
				var fvis = "";
				$( "#visn option:selected" ).each(function() {
					fvis += $( this ).text();
				 });
				$('#fl').html('').prepend('<img id="locIMG" style="width:35px" src="../../includes/img/escudo/'+floc+'.png" />');
				$('#fvs').html('').html("VS");
				$('#fv').html('').prepend('<img id="locIMG" style="width:35px" src="../../includes/img/escudo/'+fvis+'.png" />');;
			}
		}else{
			$('#fl,#fvd,#fv').html('');
		}
		});
	
	$('#agregarPA').on('click',function(){
		if(camposVacios()){
			if (campoFecha()) {
				$('#resn').attr('disabled',false).trigger('chosen:updated');
				$('#agregarPA').attr('disabled',true);
				var ruta = $('#fagregarP').attr('action');
				var formData = new FormData($('#fagregarP')[0]);
					$.ajax({
						type: 'POST',
						url : ruta,
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(data){
							$("#mensaje").addClass(data.clase);
							$("#mensaje").html(data.mensaje);
							$("#mensaje").slideDown();
							setTimeout(function() {
									$("#mensaje").html('');
									$("#mensaje").removeClass(data.clase);
									//if (datos.estado == 1) {
									//	$('#uagregados').css({'display':'inline-block'});
									//	var muestra = "<tr><td><div class='marco1'><img src='../../includes/img/perfil/"+ data.img +"'/></div></td>";
									//	muestra += "<td>Nombre : </td><td>"+data.nombre+"</td>";
									//	muestra += "<td>Usuario : </td><td>"+data.usuario+"</td>";
									//	muestra += "<td>Rol : </td><td>"+data.rol+"</td>";
									//	muestra += "<td>Correo : </td><td>"+data.correo+"</td>";
									//	muestra += "<td>Telefono : </td><td>"+data.tel+"</td></tr>";
									//	
									//	$('#tuagregados').append(muestra);
									//	$('label[for='+$('input[type=text]').attr('id')+']').removeClass('error');
									//	$("input[name=limpiar]").click();
									//}
							},3000);
							
						},
						statusCode:{
							404: function(){
								alert("pagina no encontrada");
							}
						}
					});
				$('#agregarPA').attr('disabled',false);
				$('#resn').attr('disabled',true).trigger('chosen:updated');	
			}
		}
	});
	
	
	$('#gl,#gv').on('change',function(){
		var loc = $('#gl').val();
		var vis = $('#gv').val();
		if ( loc != '' && vis != '') {
		validaGoles(loc,vis);}
	});
	
	function validaGoles(loc,vis){
			if (loc >= 0 && vis >= 0) {
				if (loc == vis) {
					$('#resn').val('empate').trigger('chosen:updated');
				}else if (loc > vis) {
					$('#resn').val('local').trigger('chosen:updated');
				}else{
					$('#resn').val('visitante').trigger('chosen:updated');
				}
			}else{
				$('#resn').val('').trigger('chosen:updated');
			}
	}
	
}
function partidos(){
	$('#jorpart').on('change',function(){
		$('#feditarp').slideUp();
		$('#carga2').show();
		pars = {'operacion' : 1,'jornada': $(this).val()};
		var ruta = '../../herramientas/funcionalidad/operacionesadminpartidos.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
		$.ajax({
			type: "POST",
				url : ruta,
				data: pars,
				success: function(msg){
					//console.log(msg);
					$("#modpar").html(msg);
				},
				statusCode:{
					404: function(){
						alert("pagina no encontrada");
					}
				}
		});
	});
	
}

function EvePartidos(){
    $('.boton').button();
    $('.listas').chosen();
	$(document).tooltip();
	$('.fecha').datepicker(confDatePick3);
    comboPartidosF();
	var ruta = '../../herramientas/funcionalidad/operacionesadminpartidos.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url

	$('.editarP').on('click',function(){
		var cveP = $(this).attr('for');
		actualizaPartido(cveP,1);
	});
	
	$('#editarPG').on('click',function(){
		$('.cveParG').each(function(){
			actualizaPartido($(this).val(),0);
		});	
		$("#nota").addClass('notaBien').html("Partidos Actializados").slideDown();
		//$("#conMen"+cveP);
		setTimeout(function() {
			$("#nota").html('').removeClass('notaBien');
			//$("#conMen"+cveP).slideUp();
			pars = {'operacion' : 1,'jornada': $('#jorpart').val()};
			ajax(ruta,'POST','html',pars,false,function(msg){  $("#modpar").html(msg);} );
		},3000);
	});
	
	function actualizaPartido(cveP,tipo){
		par = {'operacion':2,'cveP':cveP,'local':$('#loc'+cveP).val(),'visitante':$('#vis'+cveP).val(),'fecha':$('#fecha'+cveP).val(),'hora':$('#hora'+cveP).val(),'jor':$('#jor'+cveP).val()};
		ajax(ruta,'POST','json',par,false,function(datos){
			if (tipo == 1) {
				$("#men"+cveP).addClass(datos.clase);
				$("#men"+cveP).html(datos.mensaje);
				$("#conMen"+cveP).slideDown();
				setTimeout(function() {
						$("#men"+cveP).html('');
						$("#men"+cveP).removeClass(datos.clase);
						$("#conMen"+cveP).slideUp();
						if (datos.estado == 1) {
							pars = {'operacion' : 1,'jornada': $('#jorv'+cveP).val()};
							ajax(ruta,'POST','html',pars,false,function(msg){  $("#modpar").html(msg);} );
						}
						
				},3000);
			}
		});
	}
	
	$('.eliminarP').on('click',function(){
		var cveP = $(this).attr('for');
		par = {'operacion':3,'cveP':cveP,'local':$('#loc'+cveP).val(),'visitante':$('#vis'+cveP).val(),'fecha':$('#fecha'+cveP).val(),'hora':$('#hora'+cveP).val(),'jor':$('#jor'+cveP).val()};
		ajax(ruta);
		
	});
}


function comboPartidosF(){
	var url = '../../herramientas/funcionalidad/combos.php?consulta=';
    $('.jorG').llenaComboNA({'url' : url+'2'},function(){
		$('.jorG').trigger('chosen:updated');
	});
	
	$('.equiG').llenaComboNA({'url' : url+'3'},function(){
		$('.equiG').trigger('chosen:updated');
	});
}
