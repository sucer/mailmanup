<?php

// Ejemplo del uso del API de Twitter con OAuth 
// más detalles en: 
// http://www.maestrosdelweb.com/editorial/twitter-autenticacion-oauth-api-login/ 

function oauth_authlink( $callback = '' ){
	include_once(path('app').'libraries/twitterOAuth.php');
	$oauth = new TwitterOAuth( Config::get('mailmanup.consumer_key'), Config::get('mailmanup.consumer_secret') );
	oauth_clearcookies();
		
	/* Solicitar el token a twitter */
	$tok = $oauth->getRequestToken( $callback );
		
	/* Dejar los tokens guardados al usuario para pasos después, son temporales */
	setcookie('oauth_request_token', $tok['oauth_token'], 0 );
	setcookie('oauth_request_token_secret', $tok['oauth_token_secret'] , 0 );
		
	/* Construir el url de autenticación */
	return $oauth->getAuthorizeURL($tok['oauth_token'],true);
}

function oauth_authenticate(){
	$token = isset( $_GET['oauth_token'] ) ? $_GET['oauth_token'] : '';
	$oauth_verifier = isset( $_GET['oauth_verifier'] ) ? $_GET['oauth_verifier'] : null;
		
	if ( $token == '' || !isset($_COOKIE['oauth_request_token']) || !isset($_COOKIE['oauth_request_token_secret']) 
	|| $_COOKIE['oauth_request_token']=='' || $_COOKIE['oauth_request_token_secret']=='' 
	|| $token != $_COOKIE['oauth_request_token'] ) 
	{
		return false;
	}

	// Usamos los tokens temporales
	include_once(path('app').'libraries/twitterOAuth.php');
	$to = new TwitterOAuth(Config::get('cognos.consumer_key'), Config::get('mailmanup.consumer_secret'), $_COOKIE['oauth_request_token'], $_COOKIE['oauth_request_token_secret']);

	/* Ahora solicitamos los tokens de acceso, que serán permanentes */
	$tok = $to->getAccessToken( $oauth_verifier );
	if ( $to->lastStatusCode() != 200 )
		return false;
		
	$token = (string) $tok['oauth_token'];
	$token_secret = (string) $tok['oauth_token_secret'];
	$userid = (int) $tok['user_id'];
	if ($userid == 0 || empty($token) || empty($token_secret) )
		return false;
			
	$info = array();
	$info['userid'] = $userid;
	$info['token'] = $token;
	$info['token_secret'] = $token_secret;
		
	return $info;
}

function authenticate_user() {	
	$info = oauth_authenticate();
	if ( $info == false || !is_array($info) ) 
	{
		die( 'Autenticación no completada, datos incorrectos' ); // ustedes deben usar algo más elegante que die()
	}

	global $db;
	$user = $db->get_user( $info['userid'] );
	if ( empty($user) )  // primera vez por acá
	{
		$user = $db->add_user_from_twitter($info['userid'], $info['token'], $info['token_secret']);
	} else 
	{ // solo actualizar los tokens de acceso
		$db->update_user_tokens($info['userid'], $info['token'], $info['token_secret']);
	}
	
	oauth_clearcookies();
	auth_create_cookie( $info['userid'] );
	
	global $config;
	header('Location: ' . SITE_URL, true, 301);
	die;
}


function auth_create_cookie($userid){
	global $config, $db;

	if ( empty($userid) ){
		return false;
	}
	$user = $db->get_user($userid);
	if ( empty($user) || strlen($user->token_secret)<1 )
		return false;
	
	$expiration = $_SERVER['REQUEST_TIME'] + 1382400;

	// based on wp_generate_auth_cookie() function from Wordpress.
	$pass_frag = substr($user->token_secret, 4, 15);
	
	$key  = hash_hmac('md5', $user->userid . $pass_frag . '|' . $expiration, Config::get('mailmanup.cookie_key') );
	$hash = hash_hmac('md5', $user->userid . '|' . $expiration, $key);
	
	$cookie = $user->userid . '|' . $expiration . '|' . $hash;
	
	$cookie_name = Config::get('mailmanup.cookie_prefix'). md5( Config::get('mailmanup.site_url') );

	setcookie($cookie_name, $cookie, $expiration, onfig::get('mailmanup.SITE_URL') . '/', '', false, true);
}

function auth_verify_cookie(){
	global $config, $db;
	$cookie_name = Config::get('mailmanup.cookie_prefix') . md5( Config::get('mailmanup.site_url') );
	if ( !isset( $_COOKIE[$cookie_name])  )
		return false;

	$info		=  explode('|', $_COOKIE[$cookie_name] );
	$userid		= (int) isset( $info[0] ) ? $info[0] : 0;
	$expiration = (int) isset( $info[1] ) ? $info[1] : 0;
	$hmac		=		isset( $info[2] ) ? $info[2] : false;
	
	if ( $expiration < $_SERVER['REQUEST_TIME'] )
		return false;
	
	$user = $db->get_user($userid);
	if ( empty($user) )
		return false;

	$pass_frag = substr($user->token_secret, 4, 15);
	$key  = hash_hmac('md5', $user->userid . $pass_frag . '|' . $expiration, Config::get('mailmanup.cookie_key'));
	$hash = hash_hmac('md5', $user->userid . '|' . $expiration, $key);

	if ( $hmac != $hash )
		return false;

	global $current_user;
	
	$current_user = $user;
	return true;
}

function oauth_clearcookies() {
	global $config;
	$expire = $_SERVER['REQUEST_TIME'] - 31536000;
	
	$cookie_name = Config::get('mailmanup.cookie_prefix') . md5( Config::get('mailmanup.site_url') ); 
	setcookie($cookie_name, '', $expire );
}
