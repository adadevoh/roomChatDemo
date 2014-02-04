<?php
//Abstract class for all controllers

 abstract class Controller{
	public $actions = array(), $model;

	protected static $nonce = NULL;


	/*-----------------Initialize the View----------------------*/

	public function __construct($options){
		if (!is_array($options)){
			throw new Exception("No options were supplied for this session");
		}
		if (DEBUG) echo"working class homie";
	}

	//Nonce to prevent XSS and duplicate submissions

	protected function generate_nonce(){
		//TODO add nonce script
		if(empty(self::$nonce)){
			self::$nonce =  base64_encode(uniqid(NULL, TRUE));
			$_SESSION['nonce'] = self::$nonce;
		}
		return self::$nonce;
	}

	protected function check_nonce(){
		if(
			isset($_SESSION['nonce']) && !empty($_SESSION['nonce'])
			&& isset($_POST['nonce']) && !empty($_POST['nonce'])
			&& $_SESSION['nonce'] === $_POST['nonce']) {

			$_SESSION['nonce'] = NULL;
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	//Handle Form submissions
	protected function handle_form_submission($action){
		if($this->check_nonce()){
			//call method specified by the action
			$output = $this->{$this->actions[$action]}();

			if(is_array($output) && isset($output['room_id'])){
				$room_id = $output['room_id'];
			}
			else{
				throw new Exception("Form Submission Failed", 1);				
			}

			header('Location: '.APP_URL.'/room/'.$room_id);
			exit;
		}
		else{
			throw new Exception("Invalid Nonce", 1);
		}
	}


	//sanitize input
	protected function sanitize($dirty){
		return htmlentities(strip_tags($dirty), ENT_QUOTES);
	}

	//set title for view
	//title to be used in <title>
	abstract public function get_title();

	//load and output view markup
	abstract public function output_view();

}
//test class
//$tr = $arrayName = array("sw","rr" );
//$obj = new Controller($tr);

	?>