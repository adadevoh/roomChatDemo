<?php

$_C = array();


#General config
date_default_timezone_set('America/New_York');

$_C['APP_TIMEZONE'] = 'America/New_York';



#Database config
#$constant = "";
$_C['DB_HOST'] = 'localhost' ;
$_C['DB_NAME'] = 'Chat_Room_App' ;
$_C['DB_USER'] = 'root' ;
$_C['DB_PASS'] = '' ;


$_C['DEBUG'] = TRUE;

foreach ($_C as $constant => $value) {
	# code...
	define($constant, $value);
	//echo"constant". $constant."<br>";
}

?>