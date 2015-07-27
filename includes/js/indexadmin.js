//evento para disparar la funcion que cambia los menus
$('#principal .enlacemenup').on('click',function(){
	var opcion = $(this).attr('id');
	for(var i = 1; i <= $('.enlacemenup').size(); i++){
		if(i == opcion){
			$('#'+i+ ' img').removeClass('menudes');
			$('#'+i).css({'font-size':'1em'});
		}else{
			$('#'+i+ ' img').addClass('menudes');
			$('#'+i).css({'font-size':'.8em'});
		}
	}
	$('#contenido_principal').html('');
	menu(opcion,'menu_secundario');
});



//funcion que muestra el menu de acuerdo al seleccionado
function menu(opcion,donde){
	
    var ruta = '../../herramientas/funcionalidad/menuadmin.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'menu': opcion}; //asignamos el parametro que se enviara, en este caso es n 
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
        success: function(msg){
			$("#" + donde).html(msg);
			$("#secundario").animate({left:'5px'},100);
			indexSecundario();
			if(opcion == 21 || opcion == 22){
				combo();
			}
			if(opcion == 35){
				comboJor();
			}
			
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
}

//funcion que llena los combos
function combo() {
  var url = '../../herramientas/funcionalidad/combos.php?consulta=';
  // * false -> quita el option "Seleccione"
  $('#usuariosedit, #usuariosdel').llenaCombo({'url' : url+'1'},function(){
		//console.log($(this));
		$('#usuariosedit, #usuariosdel').trigger('chosen:updated');
		
  });
  //llenaCombo(url+'1','#usuariosedit, #usuariosdel');
}

function comboJor(){
	 var url = '../../herramientas/funcionalidad/combos.php?consulta=';
  // * false -> quita el option "Seleccione"
  $('#jorpart').llenaCombo({'url' : url+'2'},function(){
		//console.log($(this));
		$('#jorpart').trigger('chosen:updated');
		
  });
	
}