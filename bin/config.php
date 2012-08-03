<?php


//===============================================
// Configuration
//===============================================

if( class_exists('Config') && method_exists(new Config(),'register')){ 

	// Register variables
	Config::register("singly", "key", "01234567890");
	Config::register("singly", "secret", "012345678901234567890123456789");
	Config::register("singly", "facebook_scope", "user_about_me");
	
}

?>