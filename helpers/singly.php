<?php
/*
	Singly wrapper for KISSCMS
	Simple API integration with KISSCMS
	Homepage: http://kisscms.com/plugins
	Created by Makis Tracend (@tracend)
*/

class Singly extends Remote_API {

	//public $singly;
	private  $config;
	private  $creds;
	public $oauth;
	
	// initialize
	function __construct(){ 
		
		$this->url = "https://api.singly.com/v0/";
		
		$this->config = $GLOBALS['config']['singly'];
		
		$this->init();
		
	}
	
	function init(){
		// load all the necessery subclasses
		$this->oauth = new Singly_OAuth();
		$this->login();
	}
	
	function login(){
		
		// get/update the creds
		$this->creds = $this->oauth->creds();
		
		// check if the credentials are empty
		return !empty($this->creds);
	
	}
	
	function me(){
		
		// get the connected services
		$me = $this->get("profiles");
		
		return $me;
		
		/*// loop through all the available services
		foreach( $me as $name=>$profile ){
			// leave the global id singly creates alone...
			if($name == "id") continue;
			// check if we have more than one accounts connected to the same service
			if(is_array($profile)){
				foreach($profile as $k => $id){
					$me[$name][$k]["data"] = $this->get("services/". $name ."/self#". $id);
				}
			} else {
				$me[$name] = $this->get("services/". $name ."/self");
			}
			
		}*/
		
	}
	
	
	function get( $service="", $params=array() ){
		
		// check cache before....
		
		// add access_token
		if( empty($params['access_token']) ) $params['access_token'] = $this->creds['access_token'];
		
		$http = new Http();
		$http->setMethod('GET');
		$http->setParams($params);
		
		$http->execute( $this->url . $service );
		
		// add here validation/conditions for result...
		$results = json_decode($http->result, true);
		
		// cache result
		//$this->setCache( $service, $params, $results );
		
		return $results;
		
	}
	
	function post( $service="", $params=array() ){
		
		// check cache before....
		
		// add access_token
		if( empty($params['access_token']) ) $params['access_token'] = $this->creds['access_token'];
		
		$http = new Http();
		$http->setMethod('POST');
		$http->setParams( $request["params"] );
		
		$http->execute( $this->url . $service );
		
		// add here validation/conditions for result...
		$results = json_decode($http->result, true);
		
		// cache result
		//$this->setCache( $service, $params, $results );
		
		return $results;
		
	}
	
	function delete(){
		
	}
	
}


?>