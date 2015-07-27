function equipos(){
    
	$('#agregarequipo').attr('disabled',true).addClass('desactivado');
	
    $('#nuevoequipo').on('click',function(){
		$('.nuevoEquipof').css('display','table-row');
		$('#nome0').focus();
    });
	
    $('#cancelnuevoequipo').on('click',function(){
		var cont = 0;
		$('.n').each(function(){
			if(cont<2){
			$(this).val('');
			cont++;
			}else{
			$(this).val(0);
			cont++;
			}
			
		});
		$('.nuevoEquipof').css('display','none');
    });
    
    $('#nome0').on('keyup',function(){
		validarEquipo($(this).val());    
    });
    
}


//Se valida equipo para que no se repita
function validarEquipo(equipo){
	
    var ruta = '../../herramientas/funcionalidad/operacionesadminequipo.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 2,'equipo':equipo}; //asignamos el parametro que se enviara
	$.ajax({
		dataType: "json",
		type: "POST",
        url : ruta,
        data: pars,
        success: function(msg){
			if (msg.edo == 1) {
				$("#mensaje").addClass(msg.clase).html(msg.mensaje);
			}else if (msg.edo == 2) {
				$("#mensaje").addClass(msg.clase).html(msg.mensaje);
			}else{
				
			}
			setTimeout(function() {
					$("#mensaje").html('');
					$("#mensaje").removeClass(msg.clase);
			},7000);
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
	
}

function agregarEquipo(){
	
	var nom = $('#nome0').val();
	var est = $('#estadio0').val();
	var lig = $('#liga0').val();
	var jj = $('#jj0').val();
	var jg = $('#jg0').val();
	var je = $('#je0').val();
	var jp = $('#jp0').val();
	var gf = $('#gf0').val();
	var gc = $('#gc0').val();
	var dg = $('#dif0').val();
	var tot = $('#tot0').val();
    var ruta = '../../herramientas/funcionalidad/operacionesadminequipo.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	if (nom == '') {
		alert();
	}
	
	
	var pars= {'operacion': 1,'nom':nom,'est':est,'lig':lig,'jj':jj,'jg':jg,'je':je,'jp':jp,'gf':gf,'gc':gc,'dg':dg,'tot':tot}; //asignamos el parametro que se enviara
	
	
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
		
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
	
}
