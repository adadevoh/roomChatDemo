<?php

/*---------------------------------------------------------------------------
---------------------Initialize Enviroment Variables -------------------------
-----------------------------------------------------------------------------*/

//absolute path to app for php includes
define('APP_PATH', dirname(__FILE__));

//app folder, path to app folder on server
define('APP_FOLDER', dirname($_SERVER['SCRIPT_NAME']));

//url path to app
define('APP_URL',
	remove_unwanted_slashes('http://' . $_SERVER['SERVER_NAME'] . APP_FOLDER));

//absolute path to system folder
define('SYS_PATH', APP_PATH. '/system');

//echo"app folder ". APP_FOLDER."<br>";
//echo"request uri". $_SERVER['REQUEST_URI']."<br>";

/*----------------------------------------------------------------------------
-------------------------------Initialize app--------------------------------- 
-----------------------------------------------------------------------------*/

//start session
if(!isset($_SESSION)){
	session_start();
}

//load config variables
require_once SYS_PATH.'/config/config.inc.php';


if($_C['DEBUG'] === TRUE){
	ini_set('display_errors', 1);
	error_reporting(E_ALL^E_STRICT);
	//echo "true";
}
else{
	ini_set('display_errors', 0);
	error_reporting(0);
	echo"false";
}

date_default_timezone_set($_C['APP_TIMEZONE']);

echo DB_USER.'<BR>';
ECHO APP_TIMEZONE;

//register class_autoloader as autoload funtion
spl_autoload_register('class_autoloader');

/*-----------------------------------------------------------------------------------
------------------------------Load and process view data----------------------------
-------------------------------------------------------------------------------------*/

//parse uri, store first element in $class name, and the rest in options

$uri_array = parse_uri();
$class_name = get_controller_classname($uri_array);
$options = $uri_array;

//if class_name is empty set default view to home
if(empty($class_name)){
	$class_name = 'Home';
}

// attempt to initialize requested view, else throw 404 error
try{
	$controller = new $class_name($options);
}
catch (exception $e){
	$options[1] = $e->getMessage();
	//$controller = new Error($options);//*** define class Error later
}

/*---------------------------------------------------------------------------------
-------------------------------Output the view-------------------------------------
----------------------------------------------------------------------------------*/

//incluedes header, requested view, and footer markup

/************uncomment**********************/
//require_once SYS_PATH.'/inc/header.inc.php';

//$controller->output_view();

//require_once SYS_PATH.'/inc/footer.php';

/*--------------------------------------------------------------------------------
--------------------------Function Declarations----------------------------------
----------------------------------------------------------------------------------*/


//parse the server[request_uri] and store information other than the server uri in an array, for display to the user eg in url, or as page name
function parse_uri()
{
	//remove subfolders where app is installed
	$real_uri = preg_replace('~^'.APP_FOLDER.'~','', $_SERVER['REQUEST_URI'], 1);

	$uri_array = explode('/', $real_uri);

	//if first element is empty, shift array down
	if(empty($uri_array[0])){
		array_shift($uri_array);
	}
	//if last element is empty remove it
	if(empty($uri_array[count($uri_array) -1])){
		array_pop($uri_array);
	}

	return $uri_array;
}

//determine controller name using first element of the URI array
function get_controller_classname(&$uri_array){
	$controller =array_shift($uri_array);
	return ucfirst($controller);
}

//example
$stack = array("orange", "banana", "apple", "raspberry");
$fruit = array_shift($stack);
print_r($fruit);

//remove unwanted slashes
function remove_unwanted_slashes($dirty_path){
	return preg_replace('~(?<!:)//~', '/', $dirty_path);
}

//class auto loader
function class_autoloader($class_name){
	$file_name = strtolower($class_name);

	//array of possible class locations
	$possible_locations = array(
		SYS_PATH.'/models/class.'.$file_name.'inc.php',
		SYS_PATH.'/controllers/class.'.$file_name.'inc.php',
		SYS_PATH.'/core/class.'.$file_name.'inc.php'
		);

	//loop through location array and check for requested file
	foreach ($possible_locations as $loc) {
		if(file_exists($loc)){
			require_once $loc;
			return TRUE;
		}
	}

	//on failure
	throw new Exception("Class $class_name not found");
}
?>

