<?php

$edgeAddr = explode( ':', getenv('WAZIGATE_EDGE_ADDR'));
empty( $edgeAddr[0]) and $edgeAddr[0] = 'localhost';
empty( $edgeAddr[1]) and $edgeAddr[1] = '880';

$hostAddr = explode( ':', getenv('WAZIGATE_HOST_ADDR'));
empty( $hostAddr[0]) and $hostAddr[0] = 'localhost';
empty( $hostAddr[1]) and $hostAddr[1] = '5544';

$sysAddr = explode( ':', getenv('WAZIGATE_SYSTEM_ADDR'));
empty( $sysAddr[0]) and $sysAddr[0] = 'localhost';
empty( $sysAddr[1]) and $sysAddr[1] = '880';

/*------------------------------*/

$_cfg = array(
	'max_login_attempts'	=>	3, // not implemented!
	
	'lang'		=> isset( $_ENV['UI_LANG']) ? $_ENV['UI_LANG'] : 'en', //Default language: en, fa, fr, ...
	
	'loraFreqs'	=> array(
		'-1'		=>	'Not Set',
		'433MHz'	=>	'433MHz (Asia)',
		'868MHz'	=>	'868MHz (EU, Africa)',
		'915MHz'	=>	'915MHz (NA, SA, OC)',
	),
	
	'APIServer'		=>	array(
			'URL'	=>	'http://'. $sysAddr[0] .':'. $sysAddr[1] .'/api/v1/',		// API server URL to communicate with the system functions
			'docs'	=>	'http://'. $_SERVER['SERVER_ADDR'] .':'. $sysAddr[1] .'/',	// URL to the API documentations
			'username'	=>	'', // getenv('WAZIGATE_SYSTEM_USERNAME')
			'password'	=>	'',
	),

	'EdgeServer'	=>	array(
			'URL'	=>	'http://'. $edgeAddr[0] .':'. $edgeAddr[1] .'/',
			'username'	=>	'',
			'password'	=>	'',
	),
	
	'HostServer'	=>	array(
			'URL'	=>	'http://'. $hostAddr[0] .':'. $hostAddr[1] .'/',
			'username'	=>	'',
			'password'	=>	'',
	),
	
	'wazidocs'	=> array(
		'git'	=> 'https://github.com/Waziup/waziup.io/commits',
	),
);

/*------------------------------*/

if( @$_ENV['DEBUG_MODE'])
{
	//error_reporting( E_WARNING & E_ERROR);
	error_reporting( E_ALL); 
	ini_set('display_errors', 1);

}else{
	error_reporting( 0); 
	ini_set('display_errors', 0);
}

//	set_time_limit(0);

/*------------------------------*/

?>
