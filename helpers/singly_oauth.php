<?php
// FIX - to include the base OAuth lib not in alphabetical order
require_once( realpath("../") . "/app/plugins/oauth/helpers/kiss_oauth.php" );

/* Singly OAuth for KISSCMS */
class Singly_OAuth extends KISS_OAuth_v2 {
	
	function  __construct( $api="singly", $url="https://api.singly.com/oauth") {

		$this->url = array(
			'authorize' 		=> "https://api.singly.com/oauth/authorize", 
			'access_token' 		=> $url ."/access_token", 
			'refresh_token' 	=> $url ."/access_token"
		);
		
		$this->redirect_uri = url("/oauth/api/". $api);
		
		parent::__construct($api, $url);
		
	}
	
	function save( $response ){
		
		// erase the existing creds
		unset($_SESSION['oauth']['singly']);
		
		// convert string into an array
		$auth = json_decode( $response, true );
		
		if( is_array( $auth ) && array_key_exists("expires", $auth) )
			// variable expires is the number of seconds in the future - will have to convert it to a date
			$auth['expiry'] = date(DATE_ISO8601, (strtotime("now") + $auth['expires'] ) );
		
		// save to the user session 
		$_SESSION['oauth']['singly'] = $auth;
	}
	
	// Helpers
	// - the Singly API doesn't offer a refresh token, so every check should be overuled 
	function checkToken(){
		return true;
	}
	
}

?>