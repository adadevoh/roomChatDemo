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


if(DEBUG === TRUE){
	ini_set('display_errors', 1);
	error_reporting(E_ALL^E_STRICT);
	//echo "true";
}
else{
	ini_set('display_errors', 0);
	error_reporting(0);
	echo"false";
}

date_default_timezone_set(APP_TIMEZONE);

if(DEBUG){
	echo DB_USER.'<BR>';
	ECHO APP_TIMEZONE;
}

//register class_autoloader as autoload function
spl_autoload_register('class_autoloader');

/*-----------------------------------------------------------------------------------
------------------------------Load and process view data----------------------------
-------------------------------------------------------------------------------------*/

//parse uri, store first element in $class name, and the rest in options

echo "<br>Print_ r(uri_array): ";
print_r($uri_array = parse_uri())."<br><br>";
echo "<br>className: ".$class_name = get_controller_classname($uri_array)."<br><br>";
$options = $uri_array;

//if class_name is empty set default view to home
if(empty($class_name)){
	echo"class name is empty";
	$class_name = 'Home';
}

// attempt to initialize requested view, else throw 404 error
try{
	$controller = new $class_name($options);
	echo"VVVAAAALLLIIIDDDD";
}
catch (exception $e){
	$options[1] = $e->getMessage();
	//$controller = new Error($options);//*** define class Error later
}

/*---------------------------------------------------------------------------------
-------------------------------Output the view-------------------------------------
----------------------------------------------------------------------------------*/

//includes header, requested view, and footer markup

/************uncomment**********************/


//load <title> for current view
//$title = $controller->get_title();

$dirty_cssBasic = /*APP_URL.*/'styles/basic.css';
$dirty_cssLayout = /*APP_URL.*/'styles/layout.css';
$dirty_cssMQ = /*APP_URL.*/'styles/mediaQueries.css';

$basic_css_path = remove_unwanted_slashes($dirty_cssBasic);
$layout_css_path = remove_unwanted_slashes($dirty_cssLayout);
$mediaQueries_path = remove_unwanted_slashes($dirty_cssMQ);



require_once SYS_PATH.'/inc/header.inc.php';

//$controller->output_view();

require_once SYS_PATH.'/inc/footer.inc.php';

echo "<br> APP FOLDER: ".APP_FOLDER."<br><br>";
echo "<br> SERVER REQ URI ".$_SERVER['REQUEST_URI']."<br><br>";

/*--------------------------------------------------------------------------------
--------------------------Function Declarations----------------------------------
----------------------------------------------------------------------------------*/



//parse the server[request_uri] and store information other than the server uri in an array, for display to the user eg in url, or as page name
function parse_uri()
{
	//remove subfolders where app is installed
	$real_uri = preg_replace('~^'.APP_FOLDER.'~','',$_SERVER['REQUEST_URI'],1);
	echo"(1)inside parse_uri() real uriii: ". $real_uri."<br><br><br>";
	$uri_array = explode('/', $real_uri);

	//if first element is empty, shift array down
	if(empty($uri_array[0])){
		array_shift($uri_array);
		echo"<br>(2)inside parse_uri() count($uri_array): ".count($uri_array)."<br>";
		echo"<br>(3)inside parse_uri() shitfted down<br>";
	}
	//if last element is empty remove it
	if(empty($uri_array[count($uri_array) -1])){
		array_pop($uri_array);
	}

	echo"<br><br>(4)inside parse_uri() uri_array ". print_r( $uri_array)."<br>";
	
	return $uri_array;

}

//determine controller name using first element of the URI array
function get_controller_classname(&$uri_array){
	echo"<br>(1)inside get_controller_classname() controller: ".$controller =array_shift($uri_array)."<br>";
	echo"<br>(2)inside get_controller_classname(), ucfirst(controller): ". ucfirst($controller);
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

echo "<BR>APP_URL: ".APP_URL."<BR>";
?>

