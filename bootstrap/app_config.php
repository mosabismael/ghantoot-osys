<?php
//main app settings
$error_report = true;
//Set running Environment
$Running_Environment = "local"; //local, server
//default app timezone
$timeZone = "Asia/Dubai";
//default app language
$lang = 'en';
//DB connection
$connect_db = true;
//multi language
$multi_lang = true;




$USER_ID = 0;
$USER_NAME = "";
$EMAIL = "";
$LEVEL = "";





define('base_url', '../' );
define('images_root', base_url."assets/images/");
define('assets_root', base_url."assets/");
define('api_root', base_url."app_api/");
define('uploads_root', base_url."uploads/");



if( $multi_lang == true ){
	$cookie_name = "gh_lang";


	if( isset($_COOKIE[$cookie_name]) ){
		$lang = $_COOKIE[$cookie_name];
	} else {
		$lang = 'en';
	}

	if(isset($_GET['nw_lang'])){
		$nw_lang = $_GET['nw_lang'];
		
	switch($nw_lang){
		case 'en':
			$lang = 'en';
			break;
		case 'ar':
			$lang = 'ar';
			break;
		default:
			$lang = 'en';
			break;
	}

	$cookie_value = $lang;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

	}
}





















if($error_report == true){
		error_reporting(E_ALL);
	} else {
		error_reporting(0);
	}

	

//Load language settings
require_once('lang.php');

//Load DataBase settings
require_once('app_db.php');

//Load App Main Functions
require_once('app_functions.php');



?>