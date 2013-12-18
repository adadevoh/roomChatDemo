<?php
/*----------------------Generates output for HOME PAGE*/

include_once "./../core/class.view.inc.php";
//overrides abstract class controller
class Home extends Controller
{
	public function __construct(){
		return TRUE;
	}

	//get page title
	public function get_title(){
		return "Chat Room Request";
	}

	//load output view
	public function output_view(){
		$view = new View('home');
		$view ->nonce = $this->generate_nonce();

		echo $view->join = API_URL.'room/join';
		echo "<br>";
		echo $view->start_chat = API_URL.'room/create';
		echo "<br>";
		$view ->render();
	}
}

$obj = new Home();

$obj->output_view();

?>