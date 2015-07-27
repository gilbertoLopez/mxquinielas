function indexSecundario(){
	camposObli();
	$(document).tooltip();
	$('.boton').button();
	cargaBotones();
	$('.fecha').datepicker(confDatePick2);
	$('.listas').chosen();
	$('#clave, #clave2').attr('disabled',true).css('background','rgba(255, 255, 255, 0.2)');
	$('#usuariosedit, #usuariosdel').trigger('chosen:updated');

	$('input[name=limpiar]').on('click',function(){
		limpiar();
	});

	$('input[name=cancelar]').on('click',function(){
		cancelar();
	});
	$('#secundario li').off('click');
	$('#secundario li').on('click',function(){
		var opcion = $(this).attr('id');
		$('#secundario li').each(function(){
			$(this).find('img').addClass('menudes');
			$(this).css({'font-size':'.8em'});
		});
		$(this).find('img').removeClass('menudes');
		$(this).css({'font-size':'1em'});
		$('#carga').css('display','block');
		$('.oculta').hide('slide');
		menu(opcion,'contenido_principal');
	});

	$('#agregar').on('click',function(){
		agregarUsuario();
	});

	$('#clave, #clave2').on('keyup',function(){
		validaPass($('#clave').val(),$('#clave2').val());
	});

	$('#usuario').on('keyup',function(){
		validarUsuario($(this).val());
	});

	$('#usuario2').on('keyup',function(){
		validarUsuarioCreado($(this).val());
	});

	$('#usuariosedit').on('change',function(){
		traerUsuario($(this).val(),'Actualizar');
	});

	$('#usuariosdel').on('change',function(){
		traerUsuario($(this).val(),'Eliminar');
	});

	$('#Actualizar').on('click',function(){
		editarUsuario();

	});
	$('#Eliminar').on('click',function(){
		eliminarUsuario();
	});
	$('#verusuarios').on('click',function(){
		detalleCat();
	});
	
	$('#sinimg').on('click',function(){
		if($(this).is(':checked')) {
			$('#eperfil').attr('disabled','true').val('');
		}else{
			$('#eperfil').removeAttr('disabled');
		}
	});
	
		
	
}