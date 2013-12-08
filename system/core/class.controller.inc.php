<?php

abstract class controller{
	public actions = array(), model;

	protected static $nonce = NULL;


	/*-----------------Initialize the View----------------------*/

	public function __construct($options){
		if (!is_array($options)){
			throw new Exception("No options were supplied for this session");
		}
	}

	//Nonce to prevent XSS and
}

?>