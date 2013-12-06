<?php

$_C = array();


#General config
date_default_timezone_set('America/New_York');

$_C['APP_TIMEZONE'] = 'America/New_York';



#Database config
#$constant = "";
$_C['db_hostname'] = '163.118.3.4' ;
$_C['db_name'] = 'Chat_Room_App' ;
$_C['db_username'] = 'root' ;
$_C['db_password'] = '' ;


$_C['DEBUG'] = TRUE;

foreach ($_C as $key => $value) {
	# code...
	define($constant, $value);
	//echo"constant". $constant."<br>";
}

?>