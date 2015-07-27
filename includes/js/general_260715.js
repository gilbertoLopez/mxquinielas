//enviar valores de password via ajax para validacion
function validaPass(con1,con2){
	if(con1 != '' && con2 != ''){
		if(con1 == con2){
			$('#agregar').attr('disabled',false);
			var mensaje = "<p style='color: green;font-size:1em;'>Las contrase&ntilde;as coinciden</p>";
			$('#validaciones').html(mensaje);
			$('#clave, #clave2').css({'background':'rgba(32, 193, 44, 0.2)','color':'#fff'});
			return true;
		}else{
			$('#agregar').attr('disabled',true);
			var mensaje = "<p style='color: #ee2d23;font-size:1em;'>Las contrase&ntilde;as no coinciden</p>";
			$('#validaciones').html(mensaje);
			$('#clave, #clave2').css({'background':'rgba(228, 37, 44, 0.2)','color':'#fff'});
			return false;
		}
	}else{
		$('#clave, #clave2').css({'background':'#fff','color':'#000'});
		$('#validaciones').html('');
		$('#agregar').attr('disabled',false);
		return true;
	}
}
//se validaque no haya campos vacios
function camposVacios(){
	var mensaje = "Debe capturas los siguientes campos, son obligatorios: ";
	var contvacios =0;
	$('.requerido').each(function(){
		if($(this).val() == ''){
			$('label[for='+$(this).attr('id')+']').addClass('error');
			mensaje += $('label[for='+$(this).attr('id')+']').text();
			mensaje += '\n';
			contvacios++;
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
	});
	if(contvacios != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}

//se agregan asteriscos a campos obligatorios
function camposObli(){
	$('.requerido').each(function(){
		$('label[for='+$(this).attr('id')+']').prepend('*');
	});
}

function limpiar(){
	$('.requerido').each(function(){
		$('label[for='+$(this).attr('id')+']').removeClass('error');
	});
	$('#clave, #clave2').css({'background':'#fff','color':'#000'}).attr('disabled','true').css('background','rgba(255, 255, 255, 0.2)');
	$('#validaciones').html('');
}

function cancelar(){
	$('.oculta').hide('slide');
	$('#secundario li').each(function(){
		$(this).find('img').removeClass('menudes');
		$(this).css({'font-size':'1em'});
	});

}

//Se valida usuario para que no se repita
function validarUsuario(usuario){
	
    var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 2,'usu':usuario}; //asignamos el parametro que se enviara
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
		$("#validaciones").html(msg);
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
	
}

//Se valida usuario para que no se repita
function validarUsuarioCreado(usuario){
	var creado = $('#usuariousuario').val();
	//alert(creado);
    var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 7,'usu':usuario,'creado':creado}; //asignamos el parametro que se enviara
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
			$("#validaciones").html(msg);
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
	
}


//funcion para agregar usuarios
function agregarUsuario(){
	
	if (!valUsuarioF()) {
		return false;
	}
	var ruta = $('#fagregar').attr('action');
	var metodo = $('#fagregar').attr('method');
	
	if ($('#perfil').val() != '') {
		var imagen = $('#perfil')[0].files[0];
		var nombre = imagen.name;
		var fileExtension = nombre.substring(nombre.lastIndexOf('.')+1);
		var fileSize = imagen.size;
		var fileType = imagen.type;
		if (!isImage(fileExtension)) {
			alert("El Archivo cargado debe ser una Imagen (.png, .jpg, .jpeg)");
			return false;
		}
	}	
	var formData = new FormData($('#fagregar')[0]);
	
	$.ajax({
		type: metodo,
        url : ruta,
        data: formData,
		cache: false,
        contentType: false,
        processData: false,
		dataType: "json",
        success: function(data){
				$("#nota").addClass(data.clase);
				$("#nota").html(data.mensaje);
				if(data.estado == 1){
					$('#uagregados').css({'display':'inline-block'});
					var muestra = "<tr><td><div class='marco1'><img src='../../includes/img/perfil/"+ data.img +"'/></div></td>";
					muestra += "<td>Nombre : </td><td>"+data.nombre+"</td>";
					muestra += "<td>Usuario : </td><td>"+data.usuario+"</td>";
					muestra += "<td>Rol : </td><td>"+data.rol+"</td>";
					muestra += "<td>Correo : </td><td>"+data.correo+"</td>";
					muestra += "<td>Telefono : </td><td>"+data.tel+"</td></tr>";
					
					$('#tuagregados').append(muestra);
					$('label[for='+$('input[type=text]').attr('id')+']').removeClass('error');
					$("input[name=limpiar]").click();
					
				}
				setTimeout(function() {
					$("#nota").html('');
					$("#nota").removeClass(data.clase);
	
				},5000);
				
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
}

//muestra los datos del usuario seleccionado en la lista desplegable
function traerUsuario(clave,accion){
	var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 3,'cveusu':clave,'accion':accion}; //asignamos el parametro que se enviara
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
				$("#modusu").html(msg);
				indexSecundario();
	    },
	    statusCode:{
			404: function(){
				alert("pagina no encontrada");
			}
	    }
	});
}
//funcion que modifica al usuario
function editarUsuario(){
	var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';

	if (!valUsuarioF()) {
		return false;
	}
	
	if ($('#eperfil').val() != '') {
		var imagen = $('#eperfil')[0].files[0];
		var nombre = imagen.name;
		var fileExtension = nombre.substring(nombre.lastIndexOf('.')+1);
		var fileSize = imagen.size;
		var fileType = imagen.type;
		if (!isImage(fileExtension)) {
			alert("El Archivo cargado debe ser una Imagen (.png, .jpg, .jpeg)");
			return false;
		}
	}	
	var formData = new FormData($('#feditar')[0]);
	
	$.ajax({
		type: 'POST',
        url : ruta,
        data: formData,
		cache: false,
        contentType: false,
        processData: false,
		dataType: "json",
        success: function(data){
				
				if(data.estado == 1){
					combo();
					traerUsuario(data.usuariio,'Actualizar');
					$('#usuariosedit').val(data.usuariio).trigger('chosen:updated');
					
				}
				
				setTimeout(function() {
					$("#nota").addClass(data.clase);
					$("#nota").html(data.mensaje);
	
				},2000);
				
				
				setTimeout(function() {
					$("#nota").html('');
					$("#nota").removeClass(data.clase);
	
				},5000);
				
	    },
	    statusCode:{
		404: function(){
            alert("pagina no encontrada");
		}
	    }
	});
}
//funcion que muestra las opciones para eliminar
function eliminarUsuario(){
	 var u =$('#usuario2').val();
	
	var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 5,'u':u}; //asignamos el parametro que se enviara
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
				$("#panel").html(msg);
				indexSecundario();
	    },
	    statusCode:{
			404: function(){
				alert("pagina no encontrada");
			}
	    }
	});
}

//funcion que elimina al usuario
function deleteUser(){
	var cu =$('#cveusuarioo').val();
	var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	var pars= {'operacion': 6,'cu':cu}; //asignamos el parametro que se enviara
	$.ajax({
	    type: "POST",
			dataType: "json",
            url : ruta,
            data: pars,
            success: function(data){
				
				
				if(data.estado == 1){
					//alert('eliminado');
					$('#fagregar, #realdel').hide('slide');
					var nota = "<br/><div id='nota' ></div>";
					$('#modusu').html(nota);
					$("#nota").addClass(data.clase);
					$("#nota").html(data.mensaje);
					combo();
					$('#usuariosdel').trigger('chosen:updated');
						
				}else{
					$("#nota").addClass(data.clase);
					$("#nota").html(data.mensaje);
				
				}
				setTimeout(function() {
					$("#nota").html('');
					$("#nota").removeClass(data.clase)
				},5000);
				
				
	    },
	    statusCode:{
			404: function(){
				alert("pagina no encontrada");
			}
	    }
	});
}
//cancelar segunda forma
function cancelar2(){
	$('#fagregar, #realdel').hide('slide');
	$('#usuariosdel').val('').trigger('chosen:updated');

}

function ajax(url,metodo,tipoRetorno,datos,async,retorno)
{
    var resultado = null;
    if (async == undefined)
    {
        async = false;
    }
    if (retorno == undefined) {
        retorno = function(){};
    }
	$.ajax({
        dataType: tipoRetorno,
		type : metodo,
		url: url,
		data: datos,
		async: async,
		success: function(datos) {
            retorno(datos);
		}
    });
}
$.fn.llenaCombo = function(opciones,retorno)
{
	var combos = $(this);
	var defecto = {
		optionIni : {
			inicio : true,
			valor : "",
			etiqueta : "Seleccione"
		},
		tipo : "json",
		metodo : "post",
		ajaxAsyn : true,
		datos : {},
		url : ""
    }
    $.extend(defecto,opciones); 
    
    if (retorno == undefined) {
        retorno = function(){};
    }
    if (defecto.optionIni.inicio == true)
    {
      opciones += "<option value='"+defecto.optionIni.valor+"'>"+defecto.optionIni.etiqueta+"</option>";
    }
    ajax(defecto.url,defecto.metodo,defecto.tipo,defecto.datos,defecto.ajaxAsyn,function(datosR){
		$.each(datosR,function(indice,valor){
            opciones += "<option value='"+valor[0]+"'>"+valor[1]+"</option>";
        });
        $(combos).html(opciones);
        retorno();
    })
}

$.fn.llenaComboNA = function(opciones,retorno)
{
	var combos = $(this);
	var defecto = {
		optionIni : {
			inicio : true,
			valor : "",
			etiqueta : "Seleccione"
		},
		tipo : "json",
		metodo : "post",
		ajaxAsyn : false,
		datos : {},
		url : ""
    }
    $.extend(defecto,opciones); 
    
    if (retorno == undefined) {
        retorno = function(){};
    }
    if (defecto.optionIni.inicio == true)
    {
      opciones += "<option value='"+defecto.optionIni.valor+"'>"+defecto.optionIni.etiqueta+"</option>";
    }
    ajax(defecto.url,defecto.metodo,defecto.tipo,defecto.datos,defecto.ajaxAsyn,function(datosR){
		$.each(datosR,function(indice,valor){
            opciones += "<option value='"+valor[0]+"'>"+valor[1]+"</option>";
        });
        $(combos).html(opciones);
        retorno();
    })
}


function totalPuntos(cve){
	jg = $('#jg' + cve).val();
	je = $('#je' + cve).val();
	jp = $('#jp' + cve).val();
	
	var tj = ((jg*1) + (je*1) + (jp*1));
	$('#jj' + cve).val(tj);
	
	var ptos = ((jg*3)+(je*1));
	
	$('#tot' + cve).val(ptos);
}

function difGoles(cve){
	gf = $('#gf' + cve).val();
	gc = $('#gc' + cve).val();
	
	var dif = ((gf*1) - (gc*1));
	$('#dif' + cve).val(dif);
	
}

function cargaBotones() {
     $(".bactualiza").button({
	icons: {
	  primary: "ui-icon-refresh"
	},
	text: false
     });
     $(".balta").button({
	icons: {
	  primary: "ui-icon-plusthick"
	},
	text: false
     });
     $(".belimina").button({
	icons: {
	  primary: "ui-icon-trash"
	},
	text: false
     });
     $(".bedita").button({
	icons: {
	  primary: "ui-icon-pencil"
	},
	text: false
     });
     $(".bbien").button({
	icons: {
	  primary: "ui-icon-check"
	},
	text: false
     });
     $(".bmal").button({
	icons: {
	  primary: "ui-icon-closethick"
	},
	text: false
     });
}

 function isImage(extension){
    switch(extension.toLowerCase()) 
    {
		case 'jpg': case 'gif': case 'png': case 'jpeg':
			return true;
			break;
		default:
			return false;
			break;
    }
 }
 
 function camposLatinos(){
	var mensaje = "Los siguientes campos solo permiten caracteres Latinos: \n";
	var nolatino =0;
	$('.latino').each(function(){
		if ($(this).val() != '') {
			if($(this).val().match(/^[0-9a-zA-Z·ÈÌÛ˙‡ËÏÚ˘¿»Ã“Ÿ¡…Õ”⁄Ò—¸‹_\s]+$/) == null){
				$('label[for='+$(this).attr('id')+']').addClass('error');
				mensaje += $('label[for='+$(this).attr('id')+']').text();
				mensaje += '\n';
				nolatino++;
			}else{
				$('label[for='+$(this).attr('id')+']').removeClass('error');
			}
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
		
	});
	if(nolatino != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}
function camposLetras(){
	var mensaje = "Los siguientes campos solo permiten Letras: \n";
	var letra =0;
	$('.letra').each(function(){
		if($(this).val().match(/[^A-Z0-9%\-,.—¡\s]/gi)){
			$('label[for='+$(this).attr('id')+']').addClass('error');
			mensaje += $('label[for='+$(this).attr('id')+']').text();
			mensaje += '\n';
			letra++;
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
	});
	if(letra != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}

 
  function camposNumericos(){
	var mensaje = "Los siguientes campos solo permiten Numeros: \n";
	var numero =0;
	$('.numeros').each(function(){
		if($(this).val().match(/^[0-9]+$/) == null){
			$('label[for='+$(this).attr('id')+']').addClass('error');
			mensaje += $('label[for='+$(this).attr('id')+']').text();
			mensaje += '\n';
			numero++;
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
	});
	if(numero != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}

function campoCorreo(){
	var mensaje = "El campo correo debe contener un email correcto, ejemplo : quinielasmx@hotmail.com  \n";
	var correo =0;
	$('.correo').each(function(){
		if($(this).val().match(/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/) == null){
			$('label[for='+$(this).attr('id')+']').addClass('error');
			correo++;
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
	});
	if(correo != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}

function campoFecha(){
	var mensaje = "Los campos de fecha deben contener un formato dd/mm/aaaa : corregir los campos  \n";
	var fecha =0;
	$('.fecha').each(function(){
		if($(this).val().match(/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)\d\d$/) == null){
			$('label[for='+$(this).attr('id')+']').addClass('error');
			fecha++;
		}else{
			$('label[for='+$(this).attr('id')+']').removeClass('error');
		}
	});
	if(fecha != 0){
		alert(mensaje);
		return false;
	}else{
		return true;
	}
	
}

function valUsuarioF(){
	if(!camposVacios()){
		return false;
	}
	if (!camposLatinos()) {
		return false;
	}
	$('label[for='+$('.latinos').attr('id')+']').removeClass('error');
	if ($('#fnac').val() != '') {
		if (!campoFecha()) {
			return false;
		}
	}
	$('label[for='+$('.fecha').attr('id')+']').removeClass('error');
	if ($('#correo').val() != '') {
		if (!campoCorreo()) {
			return false;
		}
	}
	$('label[for='+$('.correo').attr('id')+']').removeClass('error');
	if ($('#telefono').val() != '') {
		if (!camposNumericos()) {
			return false;
		}
	}
	$('label[for='+$('.numeros').attr('id')+']').removeClass('error');
	return true;
}


function detalleCat(){
	pars = {'operacion' : 8 };
	var ruta = '../../herramientas/funcionalidad/operacionesadminusuario.php';  //asignamos la ruta donde se enviaran los datos a una variable llamada url
	$.ajax({
	    type: "POST",
            url : ruta,
            data: pars,
            success: function(msg){
                //console.log(msg);
                $("#ventana").html(msg).dialog('open');
            },
            statusCode:{
                404: function(){
                    alert("pagina no encontrada");
                }
			}
    });
}

