<?php
//include google api files
require_once(path('app').'libraries/src/Google_Client.php');
require_once(path('app').'libraries/src/contrib/Google_Oauth2Service.php');
require_once(path('app').'libraries/authtwitter.php');
require_once(path('app').'libraries/facebook/facebook.php');

class Login_Login_Controller extends Base_Controller {

	public function action_google(){
		
		########## Google Settings.. Client ID, Client Secret #############
		$google_client_id 		= Config::get('mailmanup.google_client_id');
		$google_client_secret 	= Config::get('mailmanup.google_client_secret');
		$google_redirect_url 	= Config::get('mailmanup.google_redirect_url');
		$google_developer_key 	= Config::get('mailmanup.google_developer_key');

		$gClient = new Google_Client();
		$gClient->setApplicationName('sevenstarups.com');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);

		$google_oauthV2 = new Google_Oauth2Service($gClient);

		if ( Input::has('reset') ){
			Session::forget('token');
		  	$gClient->revokeToken();
		  	return Redirect::to(filter_var($google_redirect_url, FILTER_SANITIZE_URL));
		}

		if (Input::has('code')){ 
			$gClient->authenticate(Input::get('code'));
			Session::put('token',$gClient->getAccessToken());
			return Redirect::to(filter_var($google_redirect_url, FILTER_SANITIZE_URL));
		}
		if(Session::has('token')){ 
			$gClient->setAccessToken(Session::get('token'));
			//Get user details if user is logged in
			$user 				= $google_oauthV2->userinfo->get();
			$user_id 			= $user['id'];
			$user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
			$email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
			$profile_url 		= filter_var($user['link'], FILTER_VALIDATE_URL);
			$profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
			$personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
			Session::put('token',$gClient->getAccessToken());
var_dump($user);

		}else{
			//get google login url
			$authUrl = $gClient->createAuthUrl();
			return Redirect::to(filter_var($authUrl, FILTER_SANITIZE_URL));
		}
	}

	public function action_twitter(){
		$url =  oauth_authlink( Config::get('mailmanup.twitter_redirect_url') );
    	return Redirect::to(filter_var($url, FILTER_SANITIZE_URL));
	}

	public function action_reqtwitter(){
		authenticate_user();
	}

	public function action_facebook(){
		// manejar codigo de error, si esta presente
		if (Input::has('error_reason')) {
			 return Redirect::to('/');
		}
		// construir el objecto sdk de facebook
		$login_url = Config::get('mailmanup.fb_redirect_url');
		$fb_apikey = Config::get('mailmanup.fb_apikey');
		$fb_secret = Config::get('mailmanup.fb_secret');

		$facebook = new Facebook(array(
			'appId' => $fb_apikey,
			'secret' => $fb_secret
		));

		// obtener el codigo de respuesta
		$code = Input::get('code');

		// construir el URL de login de Facebook
		$loginUrl = $facebook->getLoginUrl(array(
			'scope' => 'email',
			'display' => 'page',
			'redirect_uri' => $login_url
		));
		// si no existe codigo de retorno de facebook, enviarmos al usuario al formulario
		// de login de Facebook
		if(empty($code)){
			return Redirect::to(filter_var($loginUrl, FILTER_SANITIZE_URL));
		}else{
			// obtener el token de autenticacion a partir de Facebook Graph
			$token_url = "https://graph.facebook.com/oauth/access_token?"
			   . "client_id=" . $fb_apikey . "&redirect_uri=" . urlencode($login_url)
			   . "&client_secret=" . $fb_secret . "&code=" . $code;

			// obtenemos la respuesta y la interpretamos
			$response = @file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);

			// asignamos al objeto Facebook el token para proceder a realizar
			// llamadas al API posteriormente
			$facebook->setAccessToken($params['access_token']);
			$fbme = $facebook->api('/me', 'GET');
			if ($fbme) {
				// teniendo el objeto Facebook ME (datos del usuario) procedemos
	            // a realizar nuestro proceso ya sea de login o registro.
				var_dump($fbme);
			} 
		}
	}

}