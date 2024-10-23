$(function(){
	/*
	FUNCIONES Y SCRIPTS PARA EL SCROLL DEL CHAT, QUE SE MANTENGA SIEMPRE ABAJO MIENTRAS SE CHATEA
	*/
	$.easing.elasout = function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	};
	$('#chat_messages').scrollTo( 0 );
	$.scrollTo( 0 );
	var $paneTarget = $('#chat_messages');
	
	chat_go_bottom_scroll();
	//Iniciamos el chat por defecto
	var data = {
		action: 'init_client'
	};
	$.post(ajaxurl,data,function(r){
		if(r){
			$('body').prepend(r);
		}
	});
	
	//Set en default para la validacion del formulario de ingreso
	$.validator.setDefaults({
    	errorElement: "span",
        errorClass: "my-error-class",
		validClass: "my-valid-class"
    });
	
	//validamos el formulario de acceso
	//Validamos y enviamos el fomulario de ingreso
   $('#chve_form_access').live('submit',function(e){
	   //Ponemos en default el submit
	   e.preventDefault(); 
	   //Chequea si el email es correcto, y si todos los campos tienen algo
   		var validator = $(this).validate(
        {
          rules: {
            email: {
              required: true,
              email: true
            },
			name: {
              required: true
            }
          }
        }
		).form();
		//el objeto validator devuelve true, entonces envia el formulario, si no devuelve un error
		if(validator){
			//Iniciamos el chat por defecto
			var data = {
				action: 'new_access',
				name:$('#chve_name').val(),
				email:$('#chve_email').val()
			};
			$.post(ajaxurl,data,function(r){
				if(r){
					var session_id = parseInt(r);
					var data_access = {
						action: 'chat_client',
						session_id:session_id
					};
					$.post(ajaxurl,data_access,function(r){
						if(r){
							$('#chve-changes').html(r);
							chat_go_bottom_scroll();
						}
					});
				}
			});
		}else{
			//Devolvemos error, si la validacion devuelve algun campo erroneo
			$('.error-form').fadeIn('slow');
		}
		return false;
    });
	
	$('#send_messages').live('submit',function(){
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		var data = {
			action: 'addMessages',
			session_id: $('#session_id').val(),
			is_support:0,
			msg: $('#msg').val()
		};
		//Borramos el textarea
		chat_reset_msg();
		//Enviamos el mensaje por ajax
		$.post(ajaxurl, data, function(r) {
			if(r){
				$('#list').append(r);
				chat_go_bottom_scroll();
			}
		});
	return false;
	});
	
	//Evento al precionar enter
	$('#msg').live('keyup', function (e) {
	   if ( e.keyCode == 13 ){
		   $('#send_messages').submit(); 
		   return false;
		}
	});
	
	//Open chat
	$('#chve-open-close').live('click',function(){
		var flag = parseInt($(this).attr('flag'));
		if(flag==1){
			$(this).addClass('chve-close-chat');
			$('#chve_init').show('slow');
		}else{
			alert('No estamos online, en este momento.');
		}
	});
	
	//Close Chat
	$('.chve-close-chat').live('click',function(){
			$(this).removeClass('chve-close-chat');
			$('#chve_init').hide('slow');
	});
	
	
});

//Reseteamos
function chat_reset_msg(){
	$('#msg').val('');
}

//Ir al ultimo li de la lista
function chat_go_bottom_scroll(){
	$('#chat_messages').scrollTo($('#list li:last'),800);
}

//Check if exist new massages
function chat_new_messages(){
	var session_id = $('#session_id').val();
	var new_time = $('#list li:last').attr('times');
	var $ajax = $('#ajax-response');	
	//Datos para refrescar el listado
	var data = {
		action: 'new_messages',
		session_id:session_id,
		times:new_time,
		is_support:1
	};
	$.post(ajaxurl,data,function(r){
		if(r){
			$('#list').append(r);
			var data_sound = {
				action: 'sounds',
				flag:1
			};
			//Llamo al sonido
			$.post(ajaxurl,data_sound,function(r){
				if(r){
					$ajax.html(r);
				}
			});
			chat_go_bottom_scroll();
		}
	});
}