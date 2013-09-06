<?php
//include google api files
require_once(path('app').'libraries/src/Google_Client.php');
require_once(path('app').'libraries/src/contrib/Google_Oauth2Service.php');

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
echo "reset ";			

		  	$gClient->revokeToken();
		  	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

		}

		if (Input::has('code')){ 
			$gClient->authenticate(Input::get('code'));
			Session::put('token',$gClient->getAccessToken());
echo "code ".Input::get('code');			
			header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

		}
		
		if(Session::has('token')){ 
echo "token ".Session::get('token');	
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
			header('Location: ' . $authUrl, true, 302);

		}
	}

}