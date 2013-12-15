<?php
//might need to include config.inc.php
abstract class Model{

	public static $db;

	//new pdo connection

	public function __construct(){
		$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;
		try{
			self::$db = new pdo($dsn, DB_USER, DB_PASS);
		}
		catch(PDOException $e){
			die("couldnt connect to database");
		}

		return TRUE;
	}
}
?>