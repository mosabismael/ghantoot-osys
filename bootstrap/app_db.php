<?php

if($connect_db == true){

$hostname_connecter = "";
$database_connecter = "";
$username_connecter = "";
$password_connecter = "";
switch($Running_Environment){
	case 'local':
		$hostname_connecter = "localhost";
		$database_connecter = "osys_db";
		$username_connecter = "root";
		$password_connecter = "";
		break;
	case 'server':
		$hostname_connecter = "localhost";
		$database_connecter = "ghant_db";
		$username_connecter = "profiles_adtcher";
		$password_connecter = "Y7yRy5JVpQSE";
		break;
}


date_default_timezone_set($timeZone);

$KONN = mysqli_connect($hostname_connecter, $username_connecter, $password_connecter, $database_connecter);

if (mysqli_connect_errno()) {
	if($error_report == true){
		printf("<br><br><br>Connect failed: %s\n", mysqli_connect_error());
		echo "no connect";
		exit();
	} else {
		//show user special error
		//todo#
	}
}

			mysqli_query($KONN,"SET NAMES 'utf8'"); 
			mysqli_query($KONN,'SET CHARACTER SET utf8');

}
			
?>