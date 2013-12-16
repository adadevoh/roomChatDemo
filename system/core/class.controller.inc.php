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
		return "temp nonce";
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