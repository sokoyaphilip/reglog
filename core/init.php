<?php
session_start();

//create config
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '',
		'username' => '',
		'password' => '',
		'db' 	=> ''

	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expire' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

//autoload all the classes
//spl = standard php library
spl_autoload_register(function( $class ) {
	require_once 'classes/'. $class . '.php';
});

//include functions
require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hasCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hasCheck->count()){
		
		$user = new User($hasCheck->first()->user_id);
		$user->login();

	}
}