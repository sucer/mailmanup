<?php

########## Google Settings.. Client ID, Client Secret #############
$google_client_id 		= Config::get('mailmanup.google_client_id');
$google_client_secret 	= Config::get('mailmanup.google_client_secret');
$google_redirect_url 	= Config::get('mailmanup.google_redirect_url');
$google_developer_key 	= Config::get('mailmanup.google_developer_key');


//include google api files
require_once(path('app').'libraries/src/Google_Client.php');
require_once(path('app').'libraries/src/contrib/Google_Oauth2Service.php');

//start session
session_start();

$gClient = new Google_Client();
$gClient->setApplicationName('sevenstarups.com');
$gClient->setClientId($google_client_id);
$gClient->setClientSecret($google_client_secret);
$gClient->setRedirectUri($google_redirect_url);
$gClient->setDeveloperKey($google_developer_key);



$google_oauthV2 = new Google_Oauth2Service($gClient);



//If user wish to log out, we just unset Session variable
if (isset($_REQUEST['reset'])){
  unset($_SESSION['token']);
  $gClient->revokeToken();
  header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
}
//Redirect user to google authentication page for code, if code is empty.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
if (isset($_GET['code'])){ 
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
	return;
}

if (isset($_SESSION['token'])){ 
	$gClient->setAccessToken($_SESSION['token']);
}

if($gClient->getAccessToken()){
	  //Get user details if user is logged in
	  $user 				= $google_oauthV2->userinfo->get();
	  $user_id 				= $user['id'];
	  $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	  $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
	  $profile_url 			= filter_var($user['link'], FILTER_VALIDATE_URL);
	  $profile_image_url 	= filter_var($user['picture'], FILTER_VALIDATE_URL);
	  $personMarkup 		= "$email<div><img src='$profile_image_url?sz=50'></div>";
	  $_SESSION['token'] 	= $gClient->getAccessToken();
	  var_dump($user);
}else{
	//get google login url
	$authUrl = $gClient->createAuthUrl();
	header('Location: ' . $authUrl, true, 302);
    die;
}
?>

