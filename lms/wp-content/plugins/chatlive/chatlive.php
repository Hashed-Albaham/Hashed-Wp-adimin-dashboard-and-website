<?php
/*
Plugin Name: Chatlive
Plugin URI: http://www.marreroclaudio.com.ar
Description: Chat para soporte al cliente, multi session.
Version: 2.0.1
Author: Claudio Adrian Marrero
Author URI: http://www.marreroclaudio.com.ar
License: GPL2
*/
/*  Copyright 2012  Claudio Adrian Marrero  (email : cmarrero01@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//Constantes para el manejo de las direcciones de archivos y URLs
define('chve_url', plugins_url().'/chatlive');
define('chve_path',ABSPATH.'/wp-content/plugins/chatlive/');
define('chve_version','2.0');
/*Comenzamos la clase*/
class Chatlive {
	//Constructor de la clase, lo usaremos para ejecutar los hooks, etc.
	public function __construct()
    {
		add_action('init', array($this, 'load_plugin_textdomain'));
		
		if(isset($_GET['page']) and ($_GET['page']=='chat-live' or $_GET['page']=='chat-live-conf') ){
			add_action('admin_head',array($this, 'chve_js_and_styles'));			
		}
		add_action('admin_menu',array($this, 'chve_menu_set'));
		//Ajax para abrir la ventana de chat del admin
		add_action('wp_ajax_windows_chat', array($this, 'chve_windows_chat_admin'));
		//Ajax para enviar nuevos mensajes desde el admin
		add_action('wp_ajax_addMessages', array($this, 'chve_addMessages'));
		add_action('wp_ajax_nopriv_addMessages', array($this, 'chve_addMessages'));
		//Ajax para emitir sonidos en el admin
		add_action('wp_ajax_sounds', array($this, 'chve_sounds'));
		add_action('wp_ajax_nopriv_sounds', array($this, 'chve_sounds'));
		//Ajax para detectar nuevas sesiones
		add_action('wp_ajax_newSessions', array($this, 'chve_check_new_sessions'));
		//Ajax para mostrar el listado de sesiones si es que hay nuevas
		add_action('wp_ajax_ListSessions', array($this, 'chve_getListSessions'));
		//Ajax para mostrar los mensajes recibidos, si es que hay nuevos.
		add_action('wp_ajax_new_messages', array($this, 'chve_new_messages'));
		add_action('wp_ajax_nopriv_new_messages', array($this, 'chve_new_messages'));
		/*hooks para el front end*/
		add_action('wp_enqueue_scripts',array($this, 'my_scripts_method'));
		//Cargamos el javascript del chat
		add_action('wp_head',array($this, 'chve_wp_head'));
		//Ajax para el chat del cliente
		add_action('wp_ajax_nopriv_init_client', array($this, 'chve_init_client'));
		add_action('wp_ajax_init_client', array($this, 'chve_init_client'));
		//Cuando se envia el formulario de acceso, se ejecuta esta funcion por ajax
		add_action('wp_ajax_nopriv_new_access', array($this, 'chve_new_access'));
		add_action('wp_ajax_new_access', array($this, 'chve_new_access'));
		//Cuando el bloque para enviar y recibir mensajes
		add_action('wp_ajax_nopriv_chat_client', array($this, 'chve_windows_chat_client'));
		add_action('wp_ajax_chat_client', array($this, 'chve_windows_chat_client'));
		
		/*FORM INSTALATIONS*/
		add_action('plugins_loaded',array($this, 'chve_update_version'));
		register_activation_hook(__FILE__,array($this, 'chve_install_function'));
		
    }//End construct
/*****************************************************************************************************************
BACKEND - FUNCIONES DE ADMINISTRACION Y CHAT DEL ADMIN
********************************************************************************************************************/	
	//ubicamos el archivo de lengauje.
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain('chatlive', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
    }//End load textdomain
	
	//Merge settings
	public function getMerge($default, $options, $array=FALSE) {
		  if (is_array($options)) {
			  $settings = array_merge($default, $options);
		  } else {
			  parse_str($options, $output);
			  $settings = array_merge($default, $output);
		  }
  
		  return ($array) ? $settings : (Object) $settings;
	}//End merge settings
	
	//Estilos y JavaScript para la seccion en el admin:
	public function chve_js_and_styles(){	?>
    	<link href="<?=chve_url;?>/css/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?=chve_url;?>/js/jquery.scrollTo-min.js"></script>
		<script type="text/javascript" src="<?=chve_url;?>/js/swfobject.js"></script>
        <script type="text/javascript" src="<?=chve_url;?>/js/admin.js"></script>
		<?php
	}//End styles and js
	
	/***************************************************
	MENU DEL CHAT
	******************************************************/
	public function chve_menu_set(){
		$chat = add_menu_page('chatlive', 'Chat Live', 'edit_pages','chat-live',array($this, 'chve_admin'));
		$settings = add_submenu_page('chat-live', 'configuracion',__('Configuracion'),'edit_pages', 'chat-live-conf', array($this, 'chve_admin_conf') );
	}//End menu
	
	/* FUNCTIONS OF ADMINS */
	//Funcion de listado de sessiones del admin
	public function chve_admin(){
		global $wpdb;
		$msg_retorno = false;
		//Eliminar session del cliente
		if(isset($_GET['eliminar']) or isset($_GET['vaciar'])){
			$session_id = (isset($_GET['eliminar']))?$_GET['eliminar']:$_GET['vaciar'];
			//Vaciar mensajes del usuario
			$delete = $wpdb->get_results('DELETE FROM chat_messages WHERE s_from = '.$session_id);
			$msg_retorno = __('Se eliminaron todos los mensajes de la sesi&oacute;n','chatlive');
			//If send delete, so delete session
			if(isset($_GET['eliminar'])){
				$delete = $wpdb->get_results('DELETE FROM chat_messages WHERE s_from = '.$session_id);
				$delete = $wpdb->get_results('DELETE FROM chat_sessions WHERE id = '.$session_id);
				$msg_retorno = __('Se elimino la sesi&oacute;n correctamente','chatlive');
			}//End if eliminar
		}//End if eliminar y vaciar
		
		
		?>
        <!-- Iniciamos el div contenedor -->
		<div class="wrap nosubsub">
			<!-- Ajax Responso es utilizado para los sonidos y recepcion de mensajes y funcuiones de ajax -->        
			<div id="ajax-response" url="<?=chve_url; ?>"></div><!-- end ajax-response -->
            <!-- Titulo de la seccion en el admin -->
			<h2><? _e('Chat live','chatlive');?></h2>
            <div id="message" class="updated below-h2" <?=(!$msg_retorno)?'style="display:none !important;"':'';?>><p><?=$msg_retorno;?></p></div>
            <!-- Inicia la segunda columna, aqui los datos se muestran cuando se pincha en el TR de alguna sesion -->
            <div id="col-container">
                <div id="col-right">
                    <div id="col-wrap">
                    
                    </div><!-- end col wrap -->
                </div><!-- end col-right -->
                <!-- Primer columna mostramos las sessiones -->
                <div id="col-left">
                    <!-- Titulo para las sesiones -->
                    <h3><? _e('Sesiones abiertas','chatlive');?></h3>
                    <!-- Listado de sesiones -->
                    <table class="widefat">
                        <thead>
                            <tr>
                                <th>...</th>
                                <th><? _e('Nombre','chatlive');?></th>
                                <th><? _e('Email','chatlive');?></th>
                                <th><? _e('Fecha','chatlive');?></th>
                            </tr>
                        </thead>
                        <tbody id="chve_Sesssiones">
                        	<?php $this->chve_getListSessions();?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>...</th>
                                <th><? _e('Nombre','chatlive');?></th>
                                <th><? _e('Email','chatlive');?></th>
                                <th><? _e('Fecha','chatlive');?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- utilizamos este input para tomar la cantidad de sesiones actuales, y saber si hay nuevas -->
                    
                    <?php $this->chve_paypal(); ?>
                </div><!-- edn col-left finalizamos la primer columna-->
        	</div><!-- end col-content -->
		<div class="clear"></div> <!-- Limpiamos los Floats de las columnas -->
		</div><!-- end wrap -->
		<?php
	}// End function chve_admin
	
	
	public function chve_getListSessions(){ 
		//Treamos de la base todas las sessiones existentes
		$sessiones = $this->chve_getSessions();
	?>
		<!-- Si la consulta a las sessiones nos devuelve algo, realizamos el listado y las contamos -->
		<?php $i=0; if($sessiones):?>
        <!-- Recorremos las sessiones -->
        <?php  foreach($sessiones as $s):?>
            <tr session_id="<?=$s->id;?>" title="<? _e('Abrir chat','chatlive'); ?>">
                <td class="icons">
                    <span id="new<?=$s->id;?>"></span>
                    <a href="admin.php?page=chat-live&vaciar=<?=$s->id;?>" title="<? _e('Vaciar','chatlive');?>"><img src="<?=chve_url;?>/images/trash.png" /></a>&nbsp;
                    <a href="admin.php?page=chat-live&eliminar=<?=$s->id;?>" title="<? _e('Eliminar','chatlive');?>"><img src="<?=chve_url;?>/images/delete.png" /></a>
                </td>
                <td><?=$s->name;?></td>
                <td><?=$s->user_email;?></td>
                <td class="date"><strong><?=$s->fecha;?></strong></td>
            </tr>
        <!-- finalizamos el foreach -->
        <?php $i++; endforeach; ?>
        <!-- si sesiones no nos devuelve nada, entonces mostramos un mensaje indicando que no hay sesiones -->
        <?php else: ?>
            <tr sessions="0">
                <td colspan="6"><? _e('No hay sesiones abiertas','chatlive');?></td>
            </tr>
        <?php endif; ?>
        <input type="hidden" name="count_sessions" id="count_sessions" value="<?=$i;?>" />
        <!-- Finalizamos la consulta a las sessiones y mostramos el footer de la tabla -->
	<?php 
		if(isset($_POST['ajax'])){
			die();
		}
	
	}//Edn List Massages
	
	//Funcion para la consulta de sisiones, filtrada o no filtrada
	public function chve_getSessions($options=array()){
		global $wpdb;
		$default['email'] = '';
		$default['id'] = '';
		$settings = $this->getMerge($default, $options);
		
		$join = $filter = '';
		
		$colums = '
		s.id,
		s.user_email,
		s.name,
		s.fecha
		';
		
		//Consultamos las sessiones por medio del ID de la session
		if(!empty($settings->id)){
			$filter.= 'AND s.id = \''.$settings->id.'\'';
		}
		
		//Consultamos las sessiones por medio del mail del usuario
		if(!empty($settings->email)){
			$filter.= 'AND s.user_email = \''.$settings->email.'\'';
		}

		$query = 'SELECT '.$colums.' FROM chat_sessions s '.$join.' WHERE 1=1 '.$filter;
	
		$sessions = $wpdb->get_results($query);
		
	return $sessions;
	}//End getSessiones
	
	
	//Funcion de configuraciones de chatlive, opciones generales, sonidos, etc.
	public function chve_admin_conf(){
		global $wpdb;
		$msg_retorno = false;
		
		//Guardamos las nuevas opciones
		if(isset($_GET['options'])){
			//Identificar si estas online o no
			if(isset($_POST['is_online'])){
				$data['is_online'] = $_POST['is_online'];
			}else{
				$data['is_online'] = 0;
			}
			//Tomamos el nombre del soporte
			if(isset($_POST['support_name']))$data['support_name'] = $_POST['support_name'];
			//Guardamos en la base de datos los datos recibidos
			if(isset($data))$wpdb->update('chat_options',$data,array('id'=>1));
			
			$msg_retorno = __('Se guardaron los datos correctamente','chatlive');
		}//End modify options
		
		//Treamos de la base todas las sessiones existentes
		$sessiones = $this->chve_getSessions();
		
		//Opciones generales del chat
		$chat_options = $this->chve_options();
		?>
        <!-- Contenedor de la seccion -->
		<div class="wrap">
        <!-- div para recibir las consultas por ajax, sonidos, etc -->
		<div id="ajax-response"></div><!-- end ajax-response -->
        	<!-- Titulo de la seccion de configuracion -->
			<h2><? _e('Configuracion de chat live','chatlive');?></h2>
            <div id="message" class="updated below-h2" <?=(!$msg_retorno)?'style="display:none !important;"':'';?>><p><?=$msg_retorno;?></p></div>
            <!-- datos del soporte -->
			<h3><? _e('Datos del Soporte','chatlive');?></h3>
            <!-- formulario para guardar los datos -->
			<form action="admin.php?page=chat-live-conf&options=1" method="post">
			<table>
				<tbody>
					<tr>
						<td><? _e('Estas ahora online?','chatlive');?> <input type="checkbox" name="is_online" id="is_online" value="1" <?=($chat_options->is_online==1)?' checked="checked"':'';?>></td>
					</tr>
					<tr>
						<td><? _e('Nombre del Soporte','chatlive');?> <input type="text" name="support_name" id="support_name" value="<?=$chat_options->support_name;?>" /></td>
					</tr>
				</tbody>
			</table>
            <!-- fin del formulario -->
            <!-- Configuracion de sonidos -->
            <h2><? _e('Configuraci&oacute;n Sonidos','chatlive');?></h2>
            <!-- Sonido de nuevas sesiones -->
			<p>
			<label for="sound_sessions"><? _e('Sonido de nueva sesi&oacute;n','chatlive');?></label>
			<select name="sound_sessions" id="sound_sessions" flag="0">
				<?php $sSessions = $this->chve_getSounds(); foreach($sSessions as $s):?>
					<option value="<?=$s->id;?>" <?=($s->in_use)?'selected="selected"':''?>><?=$s->name;?></option>
				<?php endforeach;?>
			</select>
			</p>
            <!-- Sonido de nuevos mensajes recibidos y enviados -->
			<p>
			<label for="sound_masseges"><? _e('Sonido de mensaje recibido','chatlive');?></label>
			<select name="sound_masseges" id="sound_masseges" flag="1">
				<?php $sMasseges = $this->chve_getSounds('flag=1'); foreach($sMasseges as $s):?>
					<option value="<?=$s->id;?>" <?=($s->in_use)?'selected="selected"':''?>><?=$s->name;?></option>
				<?php endforeach;?>
			</select>
			</p>
            <input type="submit" name="saveOptions" id="saveOptions" value="<? _e('Guardar configuraci&oacute;n','chatlive');?>" class="button-primary" />
            </form>
			<?php $this->chve_paypal(); ?>
			
	   </div><!-- Ennd Wrap -->
		<?php
	}//End chve_admin_conf
	
	//Opciones generales del chat
	public function chve_options($options=array()){
		global $wpdb;
		$default['support_id'] = '1';
		$settings = $this->getMerge($default, $options);
		
		$join = $filter = '';
		
		$colums = '
		o.id,
		o.is_online,
		o.support_name,
		o.support_email
		';
		//Filtramos por el id support
		$filter.= ' AND o.id = '.$settings->support_id;
		
		$query = 'SELECT '.$colums.' FROM chat_options o '.$join.' WHERE 1=1 '.$filter.' ';
	
		$options = $wpdb->get_results($query);
		
	return $options[0];
	}//End chve Options
	
	//Consultamos los sonidos a la base de datos
	public function chve_getSounds($options=array()){
		global $wpdb;
		$default['flag'] = 0;
		$default['in_use'] = 0;
		$default['sound_id'] = '';
		$settings = $this->getMerge($default, $options);
		
		$join = $filter = '';
		
		$colums = '
		s.id,
		s.name,
		s.in_use,
		s.flag';
		
		//Filtramos por sonidos de mensajes o sessiones, por defecto sesiones
		$filter.= ' AND s.flag = '.$settings->flag;
		
		//Traemos solo el que esta en uso
		if($settings->in_use==1){
			$filter.= ' AND s.in_use = '.$settings->in_use;
		}
		
		//Filtramos por ID si es necesario
		if(!empty($settings->sound_id)){
			$filter.= ' AND s.id = '.$settings->sound_id;
		}
	
		//Query
		$query = 'SELECT '.$colums.' FROM chat_sounds s '.$join.' WHERE 1=1 '.$filter;
	
		$sounds = $wpdb->get_results($query);
		
	return $sounds;
	
	}//End chve_sounds

	public function chve_paypal(){ ?>
	
		<!-- Creamos un formulario para recibir donaciones a traves de paypal -->
        <h2><? _e('Ayudanos en el desarrollo','chatlive');?></h2>
        <h4><? _e('haznos una donacion para ayudarnos a continuar con el desarrollo de este plugin.','chatlive');?></h4>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="TNWBPNVBSZDRS">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" class="button-primary" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
        </form>
        <!-- Finaliza el formulario para donaciones -->
	<?php 
	}//End function chve_paypal
	
	
	//Windows chat admin
	public function chve_windows_chat_admin() {
		global $wpdb; // this is how you get access to the database
		//Session
		$session_id = (isset($_POST['session_id']))?$_POST['session_id']:'';
		//Consultamos si existen mensajes en la base de datos, de acuerdo a la sesion
		$messages = $this->chve_getMessages('session_id='.$session_id);
		//Opciones generales del chat
		$chat_options = $this->chve_options();	
	?>
    <h2><? _e('Viendo la session:','chatlive');?>&nbsp;<?=$session_id;?></h2>
    <!-- Contenedor del chat del administrador -->
    <div id="chve-content" class="widefat">
    	<!-- Mensajes recibos y enviados -->
		<div id="chat_messages" class="box-list-messages">
        	<!-- UL list of massages -->
            <ul id="list">
                <?php 
				if($messages): foreach($messages as $m):?>
                    <li id="m<?=$m->id;?>" times="<?=$m->times;?>"><span><?=($m->is_support==0)?$m->name:$chat_options->support_name;?>&nbsp;<? _e('dice:','chatlive');?>&nbsp;</span><?=$m->msg;?></li>
                <?php 
				$times=$m->times; endforeach; else:?>
                	<li id="mError" times=""><span><?php _e('No hay ningun mensaje enviado o recibido','chatlive');?></span></li>
                <?php endif;?>
            </ul><!-- end list -->
         </div><!-- End chat_massages -->
         <form action="#" name="send_messages" id="send_messages" method="post">
            <div class="box_messages">
            <input type="hidden" name="session_id" id="session_id" value="<?=$session_id;?>" />
            <textarea name="msg" id="msg" class="box-msg"></textarea>
            <input type="submit" name="sendMessage" id="sendMessage" value="<? _e('Enviar','chatlive');?>" class="button send-msg button-primary" />
            </div>
         </form>
    </div><!-- end chve-content -->
    <script type="text/javascript">
	jQuery(function(){
		setInterval('chat_new_messages();',2000);
	});
	</script>
	<?php
		die(); // this is required to return a proper result
	}//End chve_windows_chat_admin
	
	//Devuelve los mensajes de el chat
	public function chve_getMessages($options=array()){
		global $wpdb;
		$default['session_id'] = '';
		$default['is_support'] = '';
		$default['times'] = '';
		$settings = $this->getMerge($default, $options);
		
		$join = $filter = '';
		
		$colums = '
		m.id,
		m.s_from,
		m.msg,
		m.times,
		m.is_support,
		s.user_email,
		s.name';
		
		//Filtramos por el ID de session
		$filter.= ' AND m.s_from = '.$settings->session_id;
		
		//tremos solos los mensajes del soporte y filtramos por el fecha de envio
		if($settings->is_support==1 and !empty($settings->times)){
			$filter.= ' AND m.is_support = 1 AND m.times > \''.$settings->times.'\'';
		}
		
		//Traemos solo los mensajes del cliente y filtramos por fecha de envio
		if($settings->is_support==0 and !empty($settings->times)){
			$filter.= ' AND m.is_support = 0 AND m.times > \''.$settings->times.'\'';
		}
		//Consultamos la session para traer los datos principales del cliente
		$join.= ' LEFT JOIN chat_sessions s ON s.id = m.s_from';
		//Query
		$query = 'SELECT '.$colums.' FROM chat_messages m '.$join.' WHERE 1=1 '.$filter.' ORDER BY m.times asc ';
	
		$messages = $wpdb->get_results($query);
		
	return $messages;
	}//End chve_getMessages
	
	
	//Agrega un nuevo mensaje y devuelve solo ese mensaje
	public function chve_addMessages(){
		global $wpdb;
		//Opciones generales del chat
		$chat_options = $this->chve_options();	
		//Fecha de envio del mensaje
		$time = time();
		$time = date('Y-m-d h:i:s',$time);
		//Verificamos si es cliente o soporte
		$is_support = (isset($_POST['is_support']) and $_POST['is_support']!=0)?$_POST['is_support']:0;
		$session_id = (isset($_POST['session_id']))?$_POST['session_id']:'';
		$msg = $_POST['msg'];
		//si el mensaje no viene vacio, cargamos el mensaje en la base de datos
		if($msg){
			//Creamos el array con los datos
			$data = array(
				's_from' => $session_id,
				'msg'=>$msg,
				'times'=>$time,
				'is_support'=>$is_support
			);
			//Realizamos el insert
			$retorno = $wpdb->insert('chat_messages',$data);
			//Id del mensaje
			$id_message = mysql_insert_id();
			//Treamos la session del usuario
			$user_session = $this->chve_getSessions('session_id='.$session_id);
			//Si no existe la session entonces mostramos un error
			if(!$user_session){
				echo '<li id="mError" times="'.$time.'"><span>'._e('Error en el envio del mensaje. Prueve de nuevo, o refresque la pagina','chatlive').'</span></li>';
			}
			//Nos fijamos cual es el autor del mensaje y de acuerdo a eso, mostramos cual es el autor
			$author = ($is_support==0)?$user_session[0]->name:$chat_options->support_name;
			//Si el mensaje se cargo en la base de datos, mostramos el resultado rapidamente sin consultas
			if($retorno){
				echo '<li id="m'.$id_message.'"  times="'.$time.'"><span>'.$author.'&nbsp;'.__('dice:','chatlive').'</span>: '.$msg.'</li>';
			}else{
				echo '<li id="mError"  times="'.$time.'"><span>'.__('Error:','chatlive').'</span>'.__('Su mensaje no fue enviado','chatlive').'</li>';
			}
		}else{
			if($settings->print_line){
				echo '<li id="mError" times="'.$time.'"><span>'._e('Error en el envio del mensaje. Prueve de nuevo, o refresque la pagina','chatlive').'</span></li>';
			}
		}
		die();
	}//End addMassages
	
	//Trame el SWF, que ejecuta el sonido, es llamada por ajax desde admin.js y funcionts.js
	public function chve_sounds(){
		//Identificamos si el sonido es de la sesion o de un nuevo mensaje
		$flag = (isset($_POST['flag']))?$_POST['flag']:0;
		$sound_id = (isset($_POST['sound_id']))?$_POST['sound_id']:'';
		if(!empty($sound_id)){
			$changeSound = $this->chve_changeSound('flag='.$flag.'&sound_id='.$sound_id);
		}
		//Ubicacion del archivo de sonido
		$folder = ($flag==1)?'massages':'sessions';
		//Traemos el sonido de la base de datos
		$sound = $this->chve_getSounds('flag='.$flag.'&in_use=1');
		$sound = $sound[0];
		?>
		<object id="FlashID<?=$sound->id;?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="0" height="0">
		  <param name="movie" value="<?=chve_url;?>/sounds/<?=$folder?>/<?=$sound->name;?>" />
		  <param name="quality" value="high" />
		  <param name="swfversion" value="6.0.65.0" />
		  <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
		  <param name="expressinstall" value="<?=chve_url;?>/sounds/expressInstall.swf" />
		  <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
		  <!--[if !IE]>-->
		  <object type="application/x-shockwave-flash" data="<?=chve_url;?>/sounds/<?=$folder?>/<?=$sound->name;?>" width="0" height="0">
			<!--<![endif]-->
			<param name="quality" value="high" />
			<param name="swfversion" value="6.0.65.0" />
			<param name="expressinstall" value="<?=chve_url;?>/sounds/expressInstall.swf" />
			<!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
			<!--[if !IE]>-->
		  </object>
		  <!--<![endif]-->
		</object>
        <?php
		die();
	}
	
	//Esta funcion cambia el sonido al ser seleccionado, es ejecutada mediante ajax desde el admin.js
	public function chve_changeSound($options=array()){
		global $wpdb;
		$default['flag'] = 0;
		$default['sound_id'] = '';
		$settings = $this->getMerge($default, $options);
		//Cambiar el sonido seleccionado
		if(!empty($settings->sound_id)){
			$wpdb->update('chat_sounds',array('in_use'=>0),array('flag'=>$settings->flag));
			$wpdb->update('chat_sounds',array('in_use'=>1),array('id'=>$settings->sound_id));
		}
	}//Edn chagnge sound
	
	//Verifica que no existan sesiones
	public function chve_check_new_sessions(){
		$sessions = $this->chve_getSessions();
		$total_sessions = count($sessions);
		echo $total_sessions;
		die();
	}
	
	//Chequear si hay nuevos mensajes, esta funcion se ejecuta cada 4 segundos, mediante javascript
	public function chve_new_messages(){
		//Tomamos los datos que vienen por post (Estos datos son enviados por post mediante jquery).
		$session_id = $_POST['session_id'];
		$times = $_POST['times'];
		$is_support = $_POST['is_support'];
		//Datos de soporte principales
		$chat_options = $this->chve_options();
		//Treamos la session del usuario
		$user_session = $this->chve_getSessions('session_id='.$_POST['session_id']);
		if($user_session){
			//traer mensajes del cliente, solo mayores que el tiempo del ultimo mensaje
			$messages = $this->chve_getMessages('session_id='.$session_id.'&is_support='.$is_support.'&times='.$times);
			//Si hay mensajes
			if($messages){
				//Mostramos todos los mensajes nuevos existentes en la base de datos pero solo del cliente, y en cuyo caso solo del soporte.
				foreach($messages as $m):?>
                	<?php
					//Nos fijamos cual es el autor del mensaje y de acuerdo a eso, mostramos cual es el autor
					$author = ($m->is_support==0)?$user_session[0]->name:$chat_options->support_name;
					?>
					<li id="m<?=$m->id;?>" times="<?=$m->times;?>"><span><?=$author;?>&nbsp;<?php _e('dice:','chatlive');?>: </span><?=$m->msg;?></li>
				<?php endforeach;
			}
		}
	die();
	}
	
/*****************************************************************************************************************
FRONT END - WIDGETS Y MODULO DE CHAT PARA CLIENTE
********************************************************************************************************************/
	//Cargamos jquery, la ultima version
	public function my_scripts_method() {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		wp_enqueue_script( 'jquery' );
	}    
	 
	//Incluimos el javascript necesario para ejecutarl el chat
	public function chve_wp_head(){
		wp_enqueue_script("jquery");
		?>
        <link href="<?=chve_url;?>/css/front.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?=chve_url;?>/js/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="<?=chve_url;?>/js/jquery.validate.min.js"></script>
		<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
        <script type="text/javascript" src="<?=chve_url;?>/js/front.js"></script>
		<?php
	}
	
	//Funcion init para el chat del cliente
	public function chve_init_client(){
		global $wpdb;
		$chat_options = $this->chve_options();
		if($chat_options->is_online){
			$flag = 1;
			$message = __('<span>Preguntas?,</span> chatea con nosotros','chatlive');
		}else{
			$flag = 0;
			$message = __('<span>Lo sentimos?,</span> no estamos online','chatlive');
		}
		?>
        <div class="chve-all-chat-containers">
            <div id="chve-open-close" flag="<?=$flag;?>" class="open"><?=$message;?></div>
            <div id="chve_init" class="chve-container">
                <div id="ajax-response"></div>
                <div id="chve-changes">
                    <? $this->chve_form_access(); ?>
                </div>
            </div>
        </div>
        <?php
		die();
	}
	
	//Le pedimos el email al cliente, podemos ver de solicitarle mas datos, el formulario se envia a la venta de windows, para comenzar el chat
	public function chve_form_access(){
	?>
	<div class="chve_userEmail">
		<h2>Preguntas?</h2>
		<h4>¡chatea con nosotros ahora!</h4>
		<form action="#" name="chve_form_access" id="chve_form_access" method="post">
			<table>
				<tr>
					<td>
                        <label for="chve_name"><?php _e('Tu nombre:','chatlive');?></label>
                        <input type="text" name="chve_name" id="chve_name" class="input-text" />
					</td>
				</tr>
				<tr>
					<td>
                        <label for="chve_email"><?php _e('Tu email:','chatlive');?></label>
                        <input type="text" name="chve_email" id="chve_email" class="input-text" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<input type="submit" name="sendEmail" id="sendEmail" value="<?php _e('Ingresar','chatlive');?>" class="button-access" />
					</td>
				</tr>
			</table>
		</form>
		<div class="error-form"><?php _e('Por favor verifique la informaci&oacute;n suministrada.','chatlive');?></div>
	</div>
	<?php
	}
	
	//Cuanod el usuario envia el mail, consultamos si existe en las sessiones, en caso contrario, creamos una session con ese email
	public function chve_new_access(){
		global $wpdb;
		
		//Informacion para setear la nueva sesion
		$data = array();
		//Fecha del servidor en la que ocurre todo
		$time = time();
		$fecha = date('Y-m-d h:i:s',$time);
		//email del usuario
		$data['user_email'] = (isset($_POST['email']))?$_POST['email']:'';
		//Nombre del usuario que esta accediendo
		$data['name'] = (isset($_POST['name']))?$_POST['name']:'';
		//Fecha en el array
		$data['fecha'] = $fecha;
		
		//Si el email es falso, es que nunca se envio por post, por ende lo retiramos
		if(!empty($data['user_email'])){
			//Buscamos si existe una session con el email provisto, para continuar la charla en dodnde quedo.
			$get_sessions = $this->chve_getSessions('email='.$data['user_email']);
			//En caso de qeu exista la charla, la continuamos
			if(!empty($get_sessions)){
				//Tomamos el ID de la session
				$session_id = (!empty($get_sessions[0]->id))?$get_sessions[0]->id:false;
				$wpdb->update('chat_sessions',$data,array('id'=>$session_id));
			}else{
				//Si la session no existe, entonces la tenemos que crear
				$session_id = $this->chve_addSessions($data);
			}
			//Idf de la session
			echo $session_id;

		}//En user_mail
		
	die();
	}//End access chat
	
	//Funcion para agregar nuevas sesiones, devuelve el id del registro de la tabla sessiones.
	public function chve_addSessions($options=array()){
		global $wpdb;
		$default = array();
		$settings = $this->getMerge($default, $options);
		//Si el email no esta vacio, entonces creamos la session
		if(!empty($settings->user_email)){
			//Insertamos la session en la base de datos, con emila, nombre y fecha.
			$retorno = $wpdb->insert('chat_sessions',array('user_email'=>$settings->user_email,'name'=>$settings->name,'fecha'=>$settings->fecha));
			if($retorno){
				//Tomamos el ID de ssion que fue brindado en el insert a la tabla sessiones
				$session_id = mysql_insert_id();
				return $session_id;
			}
		}
	}//End new sessions

	
	//Windows chat client
	public function chve_windows_chat_client() {
		global $wpdb; // this is how you get access to the database
		//Session
		$session_id = (isset($_POST['session_id']))?$_POST['session_id']:'';
		//Consultamos si existen mensajes en la base de datos, de acuerdo a la sesion
		$messages = $this->chve_getMessages('session_id='.$session_id);
		//Opciones generales del chat
		$chat_options = $this->chve_options();	
	?>
        <!-- Contenedor del chat del administrador -->
        <div id="chve-content">
            <!-- Mensajes recibos y enviados -->
            <div id="chat_messages" class="box-list-messages">
                <!-- UL list of massages -->
                <ul id="list">
                    <?php 
                    if($messages): foreach($messages as $m):?>
                        <li id="m<?=$m->id;?>" times="<?=$m->times;?>"><span><?=($m->is_support==0)?$m->name:$chat_options->support_name;?>&nbsp;<? _e('dice:','chatlive');?>&nbsp;</span><?=$m->msg;?></li>
                    <?php 
                    $times=$m->times; endforeach; else:?>
                        <li id="mError" times=""><span><?php _e('No hay ningun mensaje enviado o recibido','chatlive');?></span></li>
                    <?php endif;?>
                </ul><!-- end list -->
             </div><!-- End chat_massages -->
        <form action="#" name="send_messages" id="send_messages" method="post">
          <input type="hidden" name="session_id" id="session_id" value="<?=$session_id;?>" />
          <textarea name="msg" id="msg" class="chve-box-msg"></textarea>
          <input type="submit" name="sendMessage" id="sendMessage" value="<? _e('Enviar','chatlive');?>" class="button send-msg" />
       </form>
        </div><!-- end chve-content -->
        <script type="text/javascript">
        $(function(){
            setInterval('chat_new_messages();',2000);
        });
        </script>
	<?php
		die(); // this is required to return a proper result
	}//End chve_windows_chat_client
	
	/****************************************************************
	INSTALLATION PLUGINS, INSERT TABLES INTO DB
	******************************************************************/
	public function chve_install_tables($file) {
		global $wpdb;
		$sql = file_get_contents(chve_path.'/install/'.$file); // Leo el archivo
		// Lo siguiente hace gran parte de la magia, nos devuelve todos los tokens no vacíos del archivo
		$tokens = preg_split("/(--.*\s+|\s+|\/\*.*\*\/)/", $sql, null, PREG_SPLIT_NO_EMPTY);
		$length = count($tokens);
		
		$query = '';
		$inSentence = false;
		$curDelimiter = ";";
		// Comienzo a recorrer el string
		for($i = 0; $i < $length; $i++) {
			 $lower = strtolower($tokens[$i]);
			 $isStarter = in_array($lower, array( // Chequeo si el token actual es el comienzo de una consulta
				 'select', 'update', 'delete', 'insert',
				 'delimiter', 'create', 'alter', 'drop', 
				 'call', 'set', 'use'
			 ));
		
			 if($inSentence) { // Si estoy parseando una sentencia me fijo si lo que viene es un delimitador para terminar la consulta
				 if($tokens[$i] == $curDelimiter || substr(trim($tokens[$i]), -1*(strlen($curDelimiter))) == $curDelimiter) { 
					  // Si terminamos el parseo ejecuto la consulta
					  $query .= str_replace($curDelimiter, '', $tokens[$i]); // Elimino el delimitador
					  $wpdb->query($query);
					  $query = ""; // Preparo la consulta para continuar con la siguiente sentencia
					  $tokens[$i] = '';
					  $inSentence = false;
				 }//End tokends
			 }else if($isStarter) { // Si hay que comenzar una consulta, verifico qué tipo de consulta es
				 // Si es delimitador, cambio el delimitador usado. No marco comienzo de secuencia porque el delimitador se encarga de eso en la próxima iteración
				 if($lower == 'delimiter' && isset($tokens[$i+1]))  
					  $curDelimiter = $tokens[$i+1]; 
						 else
					  $inSentence = true; // Si no, comienzo una consulta 
				 $query = "";
			 }//End is starter
			 $query .= "{$tokens[$i]} "; // Voy acumulando los tokens en el string que contiene la consulta
		}//End for
	}
	//Instal tables
	public function chve_install_function(){
		$this->chve_install_tables('chatlive_tables.sql');
		$this->chve_install_tables('chatlive_tables-upgrade.sql');
		add_option("chve_version", chve_version);
	}
	//This function display only upgrade to 1.7
	public function chve_update_version(){
		if (get_site_option('chve_version') != chve_version) {
			$this->chve_install_tables('chatlive_tables-upgrade.sql');
			update_option( "chve_version", chve_version);
		}
	}
}//Fin de la clase Chatlive
//Iniciamos el plugin instanciando LA clase.
$chatlive = new Chatlive;