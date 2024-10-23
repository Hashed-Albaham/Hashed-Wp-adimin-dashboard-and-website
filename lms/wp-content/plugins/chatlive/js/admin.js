/*
Este javascript depende exlclusivamente de jquery, del Plugin ScrollTo.
*/
jQuery(function(){
	/*
	FUNCIONES Y SCRIPTS PARA EL SCROLL DEL CHAT, QUE SE MANTENGA SIEMPRE ABAJO MIENTRAS SE CHATEA
	*/
	jQuery.easing.elasout = function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	};
	jQuery('#chat_messages').scrollTo( 0 );
	jQuery.scrollTo( 0 );
	var $paneTarget = jQuery('#chat_messages');
	
	//Funcion para abrir la sala de chat desde el admin, dependiendo desde una sesion
	jQuery('#chve_Sesssiones tr').live('click',function(){
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		var data = {
			action: 'windows_chat',
			session_id: jQuery(this).attr('session_id')
		};
		jQuery.post(ajaxurl, data, function(r) {
			if(r){
				jQuery('#col-wrap').html(r);
				chat_go_bottom_scroll();
			}
		});
	});
	
	//Funcion para abrir la sala de chat desde el admin, dependiendo desde una sesion
	jQuery('#send_messages').live('submit',function(){
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		var data = {
			action: 'addMessages',
			session_id: jQuery('#session_id').val(),
			is_support: 1,
			msg: jQuery('#msg').val()
		};
		//Borramos el textarea
		chat_reset_msg();
		//Enviamos el mensaje por ajax
		jQuery.post(ajaxurl, data, function(r) {
			if(r){
				jQuery('#list').append(r);
				chat_go_bottom_scroll();
			}
		});
	return false;
	});
	
	//Evento al precionar enter
	jQuery('#msg').live('keyup', function (e) {
	   if ( e.keyCode == 13 ){
		   jQuery('#send_messages').submit(); 
		   return false;
		}
	});
	
	//Funcion para la eleccion de un sonido
	jQuery('#sound_sessions,#sound_masseges').live('change',function(){
		var flag_sound = jQuery(this).attr('flag');
		
		var data = {
			action: 'sounds',
			flag:flag_sound,
			sound_id: jQuery(this).val()
		};
		var $ajax = jQuery('#ajax-response');
		//Enviamos el mensaje por ajax
		jQuery.post(ajaxurl, data, function(r) {
			if(r){
				$ajax.html(r);
			}
		});
	return false;
	});
	
	//Si existe el objeto count_sessiones, entonces, ejecutamos cada 10 segundos y detectamos si existe o no nuevas sessiones
	var init_sessions = jQuery('#count_sessions').val();
	if(init_sessions || init_sessions==0 ){
		setInterval('check_new_session();',9000);
	}
	
});
//Reseteamos
function chat_reset_msg(){
	jQuery('#msg').val('');
}
//Ir al ultimo li de la lista
function chat_go_bottom_scroll(){
	jQuery('#chat_messages').scrollTo(jQuery('#list li:last'),800);
}

//Chequear si existen nuevas seciones
//Verificamos si hay nuevas seciones, si las hay enviamos una notificacion
function check_new_session(){
	var init_sessions = parseInt(jQuery('#count_sessions').val());
	var $ajax = jQuery('#ajax-response');
	
	var data = {
			action: 'newSessions'
		};
		
	jQuery.post(ajaxurl,data,function(r){
		//Si se envia, la info llamo al sonido
			if(r){
				cant = parseInt(r);
				//Si la cantidad de seiones es mayor a la cantidad mostrada, emito el sonido y cargo de nuevo el listado
				if(cant > init_sessions){
					var data_sound = {
						action: 'sounds',
						flag:0
					};
					//Llamo al sonido
					jQuery.post(ajaxurl,data_sound,function(r){
						if(r){
							$ajax.html(r);
						}
					});
					//Datos para refrescar el listado
					var data_list = {
						action: 'ListSessions',
						ajax:1
					};
					//Llamo al sonido
					jQuery.post(ajaxurl,data_list,function(r){
						if(r){
							jQuery('#chve_Sesssiones').html(r);
						}
					});
					
				}
			}
	});

}//Ebnd check new sessions

//Check if exist new massages
function chat_new_messages(){
	var session_id = jQuery('#session_id').val();
	var new_time = jQuery('#list li:last').attr('times');
	var $ajax = jQuery('#ajax-response');	
	//Datos para refrescar el listado
	var data = {
		action: 'new_messages',
		session_id:session_id,
		times:new_time,
		is_support:0
	};
	jQuery.post(ajaxurl,data,function(r){
		if(r){
			jQuery('#list').append(r);
			var data_sound = {
				action: 'sounds',
				flag:1
			};
			//Llamo al sonido
			jQuery.post(ajaxurl,data_sound,function(r){
				if(r){
					$ajax.html(r);
				}
			});
			chat_go_bottom_scroll();
		}
	});
}