<?php
// FIX - to include the base OAuth lib not in alphabetical order
$oauth = getPath("helpers/kiss_oauth.php");
( $oauth ) ? require_once( $oauth ) : die("The site is offline as a nessesary plugin is missing. Please install oauth: github.com/kisscms/oauth");

/* Singly OAuth for KISSCMS */
class Singly_OAuth extends KISS_OAuth_v2 {
	
	function  __construct( $api="singly", $url="https://api.singly.com/oauth") {

		$this->url = array(
			'authorize' 		=> "https://api.singly.com/oauth/authorize", 
			'access_token' 		=> $url ."/access_token", 
			'refresh_token' 	=> $url ."/access_token"
		);
		
		$this->redirect_uri = url("/oauth/api/". $api);
		
		$this->client_id = $GLOBALS['config']['singly']['key'];
	 	$this->client_secret = $GLOBALS['config']['singly']['secret'];
		
		$this->token = ( empty($_SESSION['oauth']['singly']['access_token']) ) ? false : $_SESSION['oauth']['singly']['access_token'];
	 	$this->refresh_token = ( empty($_SESSION['oauth']['singly']['refresh_token']) ) ? false : $_SESSION['oauth']['singly']['refresh_token'];
	 	
	}
	
	function save( $response ){
		
		// erase the existing cache
		$singly = new Singly();
		$singly->deleteCache();
		
		// convert string into an array
		parse_str( $response, $auth );
		
		if( is_array( $auth ) && array_key_exists("expires", $auth) )
			// variable expires is the number of seconds in the future - will have to convert it to a date
			$auth['expiry'] = date(DATE_ISO8601, (strtotime("now") + $auth['expires'] ) );
		
		// save to the user session 
		$_SESSION['oauth']['singly'] = $auth;
	}
	
}

?>