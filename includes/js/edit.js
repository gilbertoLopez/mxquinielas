$(function(){
	jQuery.validator.addMethod("birthdate", function(value, element) {
		var dateReg = /^\d{2}[./-]\d{2}[./-]\d{4}$/;
		if(dateReg.test(value)){
			var dateArray = value.split("-");
			var yyyy = parseInt(dateArray[2],10);
			var mm   = parseInt(dateArray[1],10);
			var dd   = parseInt(dateArray[0],10);
			var date = new Date(yyyy,mm-1,dd,0,0,0,0);
			return mm === (date.getMonth()+1) && dd === date.getDate() &&  yyyy === date.getFullYear();
		}
	  	return false;
	}); 
	$("#frmUsuario").validate({
		onsubmit : false,
		rules    : {
			"nombre"     : { required : true },
			"apellidopa" : { required : true },
			"apellidoma" : { required : true },
			"telefono"   : { required : true, number : true },
			"email"      : { email    : false },
			"fechaNac"   : { required : true, birthdate : true },
			"usuario"    : { required : true, remote : { url : "./herramientas/funcionalidad/ajax.php?type=user", type : "post" } },
			"clave"      : { required : "#changeUser:checked", remote : { url : "./herramientas/funcionalidad/ajax.php?type=validpass", type : "post" } },
			"clave1"     : { required : "#changeUser:checked" },
			"clave2"     : { equalTo  : "#clave1" }
		},
		messages : {
			"nombre"     : { required : "El nombre es requerido" },
			"apellidopa" : { required : "El apellido paterno es requerido" },
			"apellidoma" : { required : "El apellido materno es requerido" },
			"telefono"   : { required : "El telefono es requerido", number : "Formato no valido" },
			"email"      : { email    : "El formato no es correcto" },
			"fechaNac"   : { required : "La fecha de Nacimiento es requerido", birthdate : "La fecha es incorrecta" },
			"usuario"    : { required : "El usuario es requerido",  remote : "Usuario no disponible"},
			"clave"      : { required : "La contrase&ntilde;a es requerida", remote   : "La contrase&ntilde;a actual es erronea" },
			"clave1"     : { required : "La nueva contrase&ntilde;a es requerida" },
			"clave2"     : { equalTo  : "Las contrase&ntilde;as no son iguales" }	
		}
	});
	$("#changeUser").on("click",function(){
		if($(this).is(":checked")){
			$("#divChangeUser").show();
		}
		else{
			$("#divChangeUser").hide().find("label.error").hide().html("");
		}
	});
	$("#btnEditar").on("click",function(){
		$("#frmUsuario").valid();
	});
	$("#changeFile").on("click",function(){
		$("#filePerfil").trigger("click");
	});
	$("#frmUsuario").on("submit",function(){
		if($(this).valid()){
			$btn = $(this).find("[type=submit]");
			$btn.attr("disabled","disabled");
			$.ajax({
				url      : "./herramientas/funcionalidad/editarUsuario.php",
				type     : "post",
				data     : $(this).serialize(),
				dataType : "json"
			}).done(function(data){
				alert(data.mns);
				$btn.removeAttr("disabled");
			});
		}
		return false;
	});
});