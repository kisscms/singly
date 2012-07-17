<?php
/*
	Singly wrapper for KISSCMS
	Simple API integration with KISSCMS
	Homepage: http://kisscms.com/plugins
	Created by Makis Tracend (@tracend)
*/

class Singly extends Remote_API {

	private $key;
	private $secret;
	private $token;
	private $refresh_token;
	private $url;
	private $oauth;
	private $cache;
	public $api;
	public $me;
	
	// initialize
	function __construct(){ 
		
		$this->api = "singly";
		$this->url = "https://disqus.com/api/3.0/";
		
		$this->key = $GLOBALS['config']['singly']['key'];
	 	$this->secret = $GLOBALS['config']['singly']['secret'];
		
		$this->me = ( empty($_SESSION['oauth']['singly']['user_id']) ) ? false : $_SESSION['oauth']['singly']['user_id'];
	 	
		$this->token = ( empty($_SESSION['oauth']['singly']['access_token']) ) ? false : $_SESSION['oauth']['singly']['access_token'];
	 	$this->refresh_token = ( empty($_SESSION['oauth']['singly']['refresh_token']) ) ? false : $_SESSION['oauth']['singly']['refresh_token'];
	 	
		// check the expiry of the token
		$this->checkToken();
		
	}
		
	function post(){
		
	}
	
	function delete(){
		
	}
	
	function redirect(){
		$data = array();
		$data['url'] = $this->loginUrl;
		$data['view'] = getPath('singly/views/redirect.php');
		return $data;
	}
	
	
}


?>